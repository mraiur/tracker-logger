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


# Usage
I am running Tasker on android and each nap/core sleep the task posts a request with a token and event type to **HTTPS://SERVER/track/{EVENT_TYPE}** with post param a user hash for "some" authentication.
  
# TODO
When you visit **HTTPS://SERVER/{USERNAME}** you to see a graph/chart for each 24 our cicle in the previous 7 or more days.

Refactor the code if i get some time and continue the polyphasic sleeping. 