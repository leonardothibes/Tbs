class {'env':
	utils        => ['git','nmap'],
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
	zftool  => true,
	version => '1.12.3',
}
class {'phpmyadmin':}
