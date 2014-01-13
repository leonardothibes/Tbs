class {'env':
	utils        => ['git','nmap','wget'],
	link_in_home => ['workspace=/vagrant'],
	aliases      => ['phing=clear ; phing','phpunit=clear ; phpunit'],
}
class {'vim':
	tabstop  => 4,
	plugins  => ['puppet'],
	opt_misc => ['number','nowrap'],
}
class {'php':
	modules => ['apc','mysql','xdebug'],
	extra   => ['phpunit','phpdoc','phing','code-sniffer','composer'],
}
class {'zf':
	zftool => true,
}
class {'phpmyadmin':}
class {'apache':
	default_mods  => true,
	default_vhost => false,
	mpm_module    => 'prefork',
}
apache::vhost {'phpskel.local':
	priority      => '01',
	port          => '80',
	docroot       => '/vagrant/src/Phpskel/public',
	setenv        => ['APPLICATION_ENV development'],
	serveraliases => ['phpskel'],
}
apache::vhost {'phpmyadmin.local':
	priority      => '02',
	port          => '81',
	docroot       => '/usr/share/phpMyAdmin/current',
	serveraliases => ['phpmyadmin','myadmin'],
}
apache::mod {'php5':}
apache::mod {'rewrite':}
