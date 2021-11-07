# Installation

- [Install Git](https://git-scm.com/download/win) on your computer and pull the repo into your local machine.

- Pull from this repository using `git`, then change working branch to production branch

```
  git clone https://github.com/rawsashimi1604/1004_Project.git
  git branch -f production origin/production
  git checkout production
```

- From there you should be good to go to start coding!

- To add to the codebase use Git! `git add .` adds all changes, `git status` checks status of Git, `git commit -m ...` adds a message to your commit for better referencing, `git push origin production` pushes your code to our production branch!

```
  git add .
  git status
  git commit -m "<enter your message here>"
  git push origin production
```

- To pull from existing codebase (get our latest updates), this will pull anything from production into your current production branch.

```
  git pull
  git merge origin/production
```