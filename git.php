8.27 
diff ：
1.diff 是工作区和stage的比较。2. diff --cache 是stage和分支的比较 3.diff HEAD --file是工作区和分支的比较
具体可先修改文件一次 然后add到stage，在修改一次，并执行三个命令看结果比较。

回退修改：
如果仅仅改动了工作区的文件，还没有add，git checkout -- file即可撤销更改。即从stage里复制一份文件代替工作区的。
如果已经改动并提交到stage，那么可以先git reset HEAD file，即先从分支上复制一份文件代替工作区的，把工作的更改给撤销，如果还想撤销本地的更改，那么checkout即可。
如果已经commit了，那么可以使用git reset --hard HEAD^回退上个版本。

远程仓库：
ssh-keygen -t 'rsa' -C 'xxx@xx.com'生成公钥和秘钥，~/.ssh下
git remote add origin(name) repo_location

git push -u origin master
git pull origin master