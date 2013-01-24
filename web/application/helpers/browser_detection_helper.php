<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Browser_detection
{
	public static function get_os( $user_agent = NULL )
	{
		$user_agent = $user_agent ?: $_SERVER[ 'HTTP_USER_AGENT' ];

		$oss = array (
			'Windows 3.11'		=> '/Win16/',
			'Windows 95'		=> '/(Windows 95)|(Win95)|(Windows_95)/',
			'Windows 98'		=> '/(Windows 98)|(Win98)/',
			'Windows 2000'		=> '/(Windows NT 5.0)|(Windows 2000)/',
			'Windows ME'		=> '/Windows ME/',
			'Windows XP'		=> '/(Windows NT 5.1)|(Windows XP)/',
			'Windows 2003'		=> '/(Windows NT 5.2)/',
			'Windows Vista'		=> '/(Windows NT 6.0)/',
			'Windows 7'			=> '/(Windows NT 6.1)/',
			'Windows 8'			=> '/(Windows NT 6.2)/',
			'Windows NT 4.0'	=> '/(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)/',
			'Open BSD'			=> '/OpenBSD/',
			'Sun OS'			=> '/SunOS/',
			'Linux'				=> '/(Linux)|(X11)/',
			'Macintosh'			=> '/(Mac_PowerPC)|(Macintosh)/',
			'QNX'				=> '/QNX/',
			'BeOS'				=> '/BeOS/',
			'OS/2'				=> '/OS/2/',
			'Search Bot'		=> '/(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)/'
		);

		foreach( $oss as $os => $pattern )
		{
			if ( preg_match( $pattern, $user_agent ) )
			{
				return $os;
			}
		}

		return 'Unknown';
	}


	public static function get_ip()
	{
		return $_SERVER[ 'REMOTE_ADDR' ] ?: 'Unknown';
	}


	public static function get_browser( $user_agent = NULL )
	{
		$user_agent = $user_agent ?: $_SERVER[ 'HTTP_USER_AGENT' ];

		$oss = array (
			'Mozilla Firefox'	=> '/Firefox/i',
			'Google Chrome'		=> '/Chrome/i',
			'Apple Safari'		=> '/Safari/i',
			'Opera'				=> '/Opera/i',
			'Flock'				=> '/Flock/i',
			'Netscape'			=> '/Netscape/i',
			'Internet Explorer'	=> '/MSIE/i'
		);

		foreach( $oss as $os => $pattern )
		{
			if ( preg_match( $pattern, $user_agent ) )
			{
				return $os;
			}
		}

		return 'Unknown';
	}
}