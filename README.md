A simple log server for tracking start and end of polyphasic sleep cicles.
For now is for personal use. 

# Setup
```
	php composer.phar install
	
```
Copy the **config/config.sample.php** to **config/config.local.php** and set the environment config. 

Then run
```
	php vendor/bin/phinx migrate
```

# Preview

![Blog](http://blog.mraiur.com/files/sleep-log/v1.0.1.png)

[More on blog.mraiur.com](http://blog.mraiur.com/sleep-log)


# Usage
I am running Tasker on android and each nap/core sleep the task posts a request with a token and event type to **HTTPS://SERVER/track/{EVENT_TYPE}** with post param a user hash for "some" authentication.

## Event Types
```
	1 = Start of sleep/nap
	2 = End of sleep/nap
```

  
# TODO
Refactor the code if i get some time and continue the polyphasic sleeping. 