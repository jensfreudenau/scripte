# scripte
resizer.php search in subdirectories and resize images


lysncd on mac
get lsyncd working on Mac:
brew install rsync
brew install lsyncd
Need to install new rsync as described above, and specify sync.rsync.binary in config file as shown below.
I was getting the SSH permission denied errors described, and figured out that the ~/.ssh/config file was not being picked up for my user because of use of sudo when running lsyncd (so it uses root user's SSH config settings).
I created the following config file ~/.lsyncd:
settings {
    logfile    = "/tmp/lsyncd.log",
    statusFile = "/tmp/lsyncd.status",
    nodaemon   = true,
}
sync {
    default.rsyncssh,
    source    = "/Users/dustin/workspace/shared-dir/",
    host = "dev",
    targetdir = "/shared-dir",
    rsync     = {
        binary   = "/usr/local/bin/rsync",
        archive  = true,
        compress = true,
   },
   ssh = {
       identityFile = "/Users/dustin/.ssh/id_rsa",
       options = {
          User = 'ubuntu'
       }
  }
}
I have dev defined in ~/etc/hosts so that it resolves to the IP address, like:
10.50.12.34	dev
The key parts were defining the ssh.identityFile and ssh.options.User settings as documented in Config Layer 4
Now I am able to run using:
sudo lsyncd ~/.lsyncd
Here are some relevant issues:
	•	#301
	•	#217
