wse-cli - A command line tool for managing Wowza Streaming Engine&trade;
========================================
---
The wse-cli project is a command line utility to control Wowza Streaming Engine&trade; through the REST API. I've created this quickly as a starting point that could be more fully extended. Wowza Media Systems&trade; has an existing library as of this writing: https://github.com/WowzaMediaSystems/wse-rest-library-php This project is unaffliated with Wowza Media Systems, LLC. My hope is this project could encourage others to build a better library!

## Disclaimer

Admittedly, this is hackish right now. It may even be broken. I expect you'll look at some pieces of this and think "WTF no", and I also expect and hope that you'll channel that energy to jump in and improve things.

##Starting Point

This initial alpha release only includes two commands to manage stream targets and stream recorders. It also makes calls to `_defaultserver_` and `_defaultVHost_` directly, as this is presently hard-coded into strings within the command's URIs. 
Easy to improve upon later.

This is built upon the [Symfony Framework](https://symfony.com/) [Console component](https://symfony.com/doc/current/components/console.html).

### Installing
Recommended to use composer and install globally:

```
	composer global require bslezak/wse-cli
```

Also make sure you have the global Composer binaries directory in your PATH. This directory is platform-dependent, see Composer documentation for details. Example for some Unix systems:

`$ export PATH="$PATH:$HOME/.composer/vendor/bin"`

### Using
1. Change to the project folder and type:
`bin/wsecli`

or

2. Make sure you've followed the above installation steps and simply run `wsecli` from the command line

## Configuration
Edit the `app/config/parameters.yml` file and edit the following keys:
```
    wse_cli.hostname: hostname
    wse_cli.authMethod: none
    wse_cli.username: username
    wse_cli.password: password
```

If using an authMethod other than `none` then you must specify values for `username` and `password`.

## Commands
####StreamTargetCommand
Manipulates stream targets

```
	Usage:
	  stream:target <state-change> <application-name> <target-name>
	
	Arguments:
	  state-change          enable|disable
	  application-name      The WSE application name
	  target-name           The name of the stream target
```
####StreamRecorderCommand
Creates / destroys stream recorders

```
	Usage:
	  stream:recorder [options] [--] <new-state> <application-name> <recorder-name>
	
	Arguments:
	  new-state              start|stop Start or stop the recorder
	  application-name       The WSE application name
	  recorder-name          The name of the recorder (must match incoming stream name!)
	
	Options:
	  -s, --startOnKeyFrame  Start the recording on the next key frame.

```
## License

Apache-2.0

See the [LICENSE](http://github.com/bslezak/wse-cli/blob/master/LICENSE) file distributed with this library.

Brian Slezak <brian@theslezaks.com>