class env {
	file {"/home/vagrant/.profile":
		ensure => present,
		owner  => vagrant,
		group  => vagrant,
		mode   => 0644,
		source => "/tmp/vagrant-puppet/manifests/files/skel/.profile",
	}
	file {"/home/vagrant/.bash_logout":
		ensure  => present,
		owner   => vagrant,
		group   => vagrant,
		mode    => 0644,
		content => "clear",
	}
	file {"/home/vagrant/tmp":
		ensure => directory,
		owner  => vagrant,
		group  => vagrant,
		mode   => 0755,
	}
	file {"/home/vagrant/workspace":
		ensure => link,
		target => "/vagrant",
	}
	file {"/etc/profile.d/cp-mv-rm.sh":
		ensure => present,
		owner  => root,
		group  => root,
		mode   => 0755,
		source => "/tmp/vagrant-puppet/manifests/files/profile.d/cp-mv-rm.sh",
	}
	file {"/usr/local/bin/mysql-root-passwd":
		ensure => present,
		owner  => root,
		group  => root,
		mode   => 0755,
		source => "/tmp/vagrant-puppet/manifests/files/skel/mysql-root-passwd.sh",
	}
	file {"/usr/local/bin/puppet-run-manifests":
		ensure => present,
		owner  => root,
		group  => root,
		mode   => 0755,
		source => "/tmp/vagrant-puppet/manifests/files/skel/puppet-run-manifests.sh",
	}
}

class vim {
    
    $vim     = "vim"
	$vimpath = "/etc/vim"
	
	package {[ "$vim" , "$vim-puppet" ]: ensure => present}
	exec {"vim-addons install puppet": path => "/usr/bin"}
	exec {"update-alternatives --set editor /usr/bin/vim.basic":
		path    => "/usr/bin:/usr/sbin:/bin",
		unless  => "test /etc/alternatives/editor -ef /usr/bin/vim.basic",
		require => Package["$vim"],
	}
	file {"$vimpath/vimrc.local":
		ensure  => present,
		source  => "/tmp/vagrant-puppet/manifests/files/vim/vimrc.local",
		owner   => root,
		group   => root,
		mode    => 0644,
		require => Package["$vim"],
	}
}

class utils {
    $packages = [
		'whois',
		'lynx',
		'elinks',
		'telnet',
		'wget',
		'curl',
		'tar',
		'zip',
		'unzip',
		'bzip2',
		'traceroute',
		'tcpdump',
		'iptraf',
		'nmap',
		'less',
		'dnsutils',
		'ccze',
		'git',
		'subversion',
		'build-essential',
	]
	package {$packages: ensure  => installed}
	package {"tzdata" : ensure  => latest   }
}

class apache {
	
    package {"apache2": ensure => present}
    service {"apache2":
        ensure  => running,
        require => Package["apache2"],
    }
	
	file {"/etc/apache2/ports.conf":
		ensure  => present,
		source  => "/tmp/vagrant-puppet/manifests/files/apache/ports.conf",
		owner   => root,
		group   => root,
		mode    => 0644,
		require => Package["apache2"],
		notify  => Service["apache2"],
	}
    
    define apache::loadmodule () {
        exec {"/usr/sbin/a2enmod ${name}":
            unless  => "/bin/readlink -e /etc/apache2/mods-enabled/${name}.load",
        	require => Package["apache2"],
            notify  => Service["apache2"],
        }
    }
    apache::loadmodule{"rewrite":}
	
	file {"/etc/apache2/sites-available/default":
		ensure  => present,
		source  => "/tmp/vagrant-puppet/manifests/files/apache/default",
		owner   => root,
		group   => root,
		mode    => 0644,
        require => Package["apache2"],
		notify  => Service["apache2"],
	}
	
	file {"/etc/apache2/sites-available/phpmyadmin":
		ensure  => present,
		source  => "/tmp/vagrant-puppet/manifests/files/apache/phpmyadmin",
		owner   => root,
		group   => root,
		mode    => 0644,
        require => Package["apache2"],
		notify  => Service["apache2"],
	}
	
	file {"/etc/apache2/sites-enabled/phpmyadmin":
		ensure => link,
		target => "/etc/apache2/sites-available/phpmyadmin",
        require => Package["apache2"],
		notify  => Service["apache2"],
	}
}

class php {
    $packages = [
		'libssl0.9.8',
		'libssl-dev',
		'libapache2-mod-php5',
		'php5',
		'php-apc',
		'php-pear',
		'php5-cli',
		'php5-curl',
		'php5-dbg',
		'php5-dev',
		'php5-gd',
		'php5-imagick',
		'php5-imap',
		'php5-ldap',
		'php5-mcrypt',
		'php5-memcache',
		'php5-memcached',
		'php5-mysql',
		'php5-odbc',
		'php5-pgsql',
		'php5-pspell',
		'php5-recode',
		'php5-sqlite',
		'php5-svn',
		'php5-sybase',
		'php5-xdebug',
		'php5-xmlrpc',
		'php5-xsl',
	]
	package{$packages: ensure  => installed}
	
	file {"/etc/php5/cli/php.ini":
		ensure  => present,
		owner   => root,
		group   => root,
		mode    => 0644,
		source  => "/tmp/vagrant-puppet/manifests/files/php/php.ini",
		require => Package[$packages],
	}
	file {"/etc/php5/apache2/php.ini":
		ensure  => present,
		owner   => root,
		group   => root,
		mode    => 0644,
		source  => "/tmp/vagrant-puppet/manifests/files/php/php.ini",
		notify  => Service["apache2"],
		require => Package[$packages],
	}
	file {"/etc/php.ini":
		ensure  => link,
		target  => "/etc/php5/apache2/php.ini",
		require => Package[$packages],
	}
}

class tools {
	
	# PEAR
	$pear1="pear chanel-update pear.php.net"
	$pear2="pear config-set auto_discover 1"
	$pear3="pecl chanel-update pecl.php.net"
    exec {$pear1:
		path   => "/usr/bin",
		before => Exec[$pear2],
	}
	exec {$pear2:
		path   => "/usr/bin",
		before => Exec[$pear3],
	}
	exec {$pear3:
		path   => "/usr/bin",
	}
	#ENDS PEAR
    
	# PHING
	$phing1="pear channel-discover pear.phing.info"
	$phing2="pear install --alldeps phing/phing"
	exec {$phing1:
		path    => "/usr/bin",
		onlyif  => "test ! -f /usr/bin/phing",
		require => Exec[$pear1],
		before  => Exec[$phing2],
	}
	exec {$phing2:
		path    => "/usr/bin",
		onlyif  => "test ! -f /usr/bin/phing",
		require => Exec[$phing1],
	}
	# ENDS PHING
	
	# CODE-SNIFFER
	exec {"pear install PHP_CodeSniffer-1.4.5":
		path    => "/usr/bin",
		onlyif  => "test ! -f /usr/bin/phpcs",
		require => Exec[$pear1],
	}
	# ENDS CODE-SNIFFER
	
	# PHP DOCUMENTOR
	$phpdoc1="pear channel-discover pear.phpdoc.org"
	$phpdoc2="pear install phpdoc/phpDocumentor-alpha"
	exec {$phpdoc1:
		path    => "/usr/bin",
		onlyif  => "test ! -f /usr/bin/phpdoc",
		require => Exec[$pear1],
		before  => Exec[$phpdoc2],
	}
	exec {$phpdoc2:
		path   => "/usr/bin",
		onlyif => "test ! -f /usr/bin/phpdoc",
		require => Exec[$pear1],
	}
	# ENDS PHP DOCUMENTOR
	
	# PHPUNIT
	$phpunit="pear install pear.phpunit.de/PHPUnit-3.7.22"
	exec {$phpunit:
		path    => "/usr/bin",
		onlyif  => "test ! -f /usr/bin/phpunit",
		require => Exec[$pear1],
	}
	exec {"pear install pear.phpunit.de/DbUnit":
		path    => "/usr/bin",
		onlyif  => "test ! -f /usr/bin/dbunit",
		require => [Exec[$pear1], Exec[$phpunit]],
	}
	exec {"pear install pear.phpunit.de/PHP_Invoker":
		path    => "/usr/bin",
		onlyif  => "test ! -f /usr/share/php/PHP/Invoker.php",
		require => [Exec[$pear1], Exec[$phpunit]],
	}
	exec {"pear install pear.phpunit.de/PHPUnit_Selenium":
		path    => "/usr/bin",
		onlyif  => "test ! -f /usr/share/php/PHPUnit/Extensions/SeleniumTestCase.php",
		require => [Exec[$pear1], Exec[$phpunit]],
	}
	exec {"pear install pear.phpunit.de/PHPUnit_Story":
		path    => "/usr/bin",
		onlyif  => "test ! -d /usr/share/php/PHPUnit/Extensions/Story",
		require => [Exec[$pear1], Exec[$phpunit]],
	}
	exec {"pear install pear.phpunit.de/PHPUnit_SkeletonGenerator":
		path    => "/usr/bin",
		onlyif  => "test ! -d /usr/share/php/SebastianBergmann/PHPUnit/SkeletonGenerator",
		require => [Exec[$pear1], Exec[$phpunit]],
	}
	# ENDS PHPUNIT
	
	# COMPOSER
	exec  {"curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin":
		path    => "/usr/bin",
		onlyif  => "test ! -f /usr/bin/composer.phar",
		require => Package["php5"],
	}
	file {"/usr/bin/composer":
		ensure => link,
		target => "/usr/bin/composer.phar",
	}
	# ENDS COMPOSER
	
	# S3CMD
	$import="wget -O- -q http://s3tools.org/repo/deb-all/stable/s3tools.key | apt-key add -"
	$repos="wget -O /etc/apt/sources.list.d/s3tools.list http://s3tools.org/repo/deb-all/stable/s3tools.list"
	$pack="s3cmd"
	
	exec {$import:
		path   => [ "/bin" , "/usr/bin" ],
		onlyif => "test ! -f /usr/bin/s3cmd",
		before => Exec[$repos],
	}
	
	exec {$repos:
		path    => [ "/bin" , "/usr/bin" ],
		onlyif  => "test ! -f /usr/bin/s3cmd",
		before  => Exec[$repos],
		require => Package[$pack],
	}
	
	package {$pack:	ensure => installed}
	# ENDS S3CMD
}

class zf {
    
    # Definições de ambiente
    $version="1.12.3"
    $pear="/usr/share/php"
    $zend="/usr/share/ZendFramework"
    $pack="ZendFramework-${version}.tar.gz"
    $bin="/usr/bin"
	$src="/usr/src"
    $tmp="/tmp"
    $url="http://packages.zendframework.com/releases/ZendFramework-${version}/${pack}"
    # Definições de ambiente
    
    # Comandos a serem executados
    $copy="cp -Rf ${tmp}/ZendFramework-${version} ${zend}/${version}"
    $tar="tar -xzvf ${src}/${pack}"
    
    # Baixando o Zend Framework
    exec {"wget ${url} -O ${src}/${pack}":
        path    => "/usr/bin",
        onlyif  => "test ! -f ${src}/${pack}",
        before  => Exec[$tar],
		require => Package["php-pear"],
    }
    # Baixando o Zend Framework
    
    # Descompactando o pacote TGZ
    exec {$tar:
        path   => [ "/bin", "/usr/bin" ],
        cwd    => $src,
        onlyif => "test ! -d ${src}/ZendFramework-${version}",
        before => Exec[$copy],
    }
    # Descompactando o pacote TGZ
    
    # Copiando o Zend Framework para o diretório definitivo
    file {$zend:
        ensure => directory,
        owner  => root,
        group  => root,
        mode   => 0755,
    }
    exec {$copy:
        path   => [ "/bin", "/usr/bin" ],
        onlyif => [
            "test -d ${tmp}/ZendFramework-${version}",
            "test ! -d ${zend}/${version}",
        ],
        require => File[$zend],
    }
    file {"${zend}/current":
        ensure => link,
        target => "${zend}/${version}",
    }
    # Copiando o Zend Framework para o diretório definitivo
    
    # Integrando o Zend Framework ao include_path do PHP
    file {"$pear/Zend":
        ensure  => link,
        target  => "${zend}/current/library/Zend",
		require => Package["php-pear"],
    }
    file {"$pear/ZendX":
        ensure  => link,
        target  => "${zend}/current/extras/library/ZendX",
		require => Package["php-pear"],
    }
    # Integrando o Zend Framework ao include_path do PHP
    
    # Instalando a Zend_Tool
    file {"$bin/zf":
        ensure => link,
        target => "${zend}/current/bin/zf.sh"
    }
    # Instalando a Zend_Tool
}

class mysql {
    package {"mysql-server": ensure => present}
    service {"mysql":
        ensure  => running,
        require => Package["mysql-server"],
    }
}

class phpmyadmin {
    
    # Definições de ambiente
    $version="3.5.8.1"
    $install="/usr/share/phpMyAdmin"
    $package="phpMyAdmin-${version}-all-languages.tar.bz2"
    $tmp="/tmp"
    $url="http://downloads.sourceforge.net/project/phpmyadmin/phpMyAdmin/${version}/phpMyAdmin-${version}-all-languages.tar.bz2"
    # Definições de ambiente
    
    # Comandos a serem executados
    $copy="cp -Rf ${tmp}/phpMyAdmin-${version}-all-languages ${install}/${version}"
    $tar="tar -jxvf ${tmp}/${package}"
    
    # Baixando o phpMyAdmin
    exec {"wget ${url} -O ${tmp}/${package}":
        path   => "/usr/bin",
        before => Exec[$tar],
        onlyif => [
            "test ! -d ${tmp}/${package}",
            "test ! -d ${install}/${version}",
        ],
    }
    # Baixando o phpMyAdmin
    
    # Descompactando o pacote TGZ
    exec {$tar:
        path   => [ "/bin", "/usr/bin" ],
        cwd    => $tmp,
        before => Exec[$copy],
        onlyif => [
            "test ! -d ${tmp}/phpMyAdmin-${version}",
            "test ! -d ${install}/${version}",
        ],
    }
    # Descompactando o pacote TGZ
    
    # Copiando o phpMyAdmin para o diretório definitivo
    file {$install:
        ensure => directory,
        owner  => root,
        group  => root,
        mode   => 0755,
    }
    exec {$copy:
        path   => [ "/bin", "/usr/bin" ],
        onlyif => [
            "test -d ${tmp}/phpMyAdmin-${version}-all-languages",
            "test ! -d ${install}/${version}",
        ],
        require => File[$install],
    }
    file {"${install}/current":
        ensure => link,
        target => "${install}/${version}",
    }
    # Copiando o phpMyAdmin para o diretório definitivo
}

stage {'preinstall': before => Stage['main']}
class apt_get_update { exec {'apt-get -y update': path => "/usr/bin" } }
class {'apt_get_update': stage => preinstall}

include env
include vim
include utils
include apache
include php
include tools
include zf
include mysql
include phpmyadmin
