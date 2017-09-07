git config --global user.name ''
git config --global user.email ''

git只能记录文本的详细修改记录，对于二进制文件无法详细的记录

git init 初始化一个仓库 会创建一个.git隐藏文件 记录文件的修改记录

git add -A / git commit -a -m
git add -u : 修改，删除的文件不包括新增的文件untracked
git add . : 修改，新增的文件不包括刪除的文件

git commit -m 

时刻掌握工作区的状态
git status

查看具体的修改
git diff (filename)

git log
查看所有的提交

HEAD（类似一个指针）指向当前版本，即最新一次的提交对应的版本状态
HEAD^指向一个版本
HEAD~2 / HEAD^^前前一个版本

回退版本先用git log查看一下之前都有哪些提交版本

如果回退了不记得最新版本的commit id但又想回去 可以git reflog查看命令历史

暂存区的概念：
工作区就是平常工作的目录，
.git这个隐藏的文件夹称之为版本库，版本库有三个相对重要的概念：
stage（暂存区） |  master(分支) | 和指向当前分支(版本？)的指针HEAD

暂存区就是保存最新改动的一个地方
比如修改了a，新增了b，那么git add后stage里就保存了这两个文件。然后commit就是把stage里的文件全部提交到分支上




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

删除：
git rm file<=> rm file ,git add file
git rm命令会删除工作区的文件，并且将这个删除该表提交到stage
等同于先rm file，然后add使得stage和工作区一致，于是工作区就没有file这个文件了，想要恢复得先从版本库里复制一份
git reset HEAD file 然后git checkout -- file恢复到本地。此时工作区干净 

8.29
创建和合并分支
git的每一次提交都是连成一条线的（同一个分支上）
master指向提交，HEAD指向master
当我们（在matser上）创建一个新的分支dev，即创建了一个类似master分支的一个指针，指向master的最新提交，并将HEAD指向dev
以后每一次提交 master分支不变化，而是dev指针往前移动一步，等在dev上的工作完成了。再把master指向dev的最新提交，HEAD指向master，即完成了合并

git checkout -b new <=> git branch new ,git checkout new
git branch => *new ,master
git checkout master , git merge new 即将new分支合并到master（master指针指向new的最新提交）
git branch -d new 删除new分支

<<<<<<<HEAD
add in HEAD（当前分支的修改内容：比如master）
——————
——————
add in dev
>>>>>>>dev（分之上的修改）

解决冲突
在git merge后发现冲突，打开产生冲突的文件修改文件，再add commit完成合并
其实多个分支公用一个stage，再分支1上修改不add不commit，切换到分支2，再提交也是可以的，只不过分支1可能不想要这个提交，也会被提交上去，所以一定要先提交再切换分支，目的是清空stage

9.1 
--no-ff
git merge 一般在没有冲突的情况下会使用fastforword的模式，即将当前分支的指针指向待合并分支的最后一次提交上
但是这样删除分之后，就看不到该分支的提交信息，所以在合并时可以禁用ff模式
采用git merge --no-ff,主分支会进行一次提交，保证和待合并分支最后一次提交时工作区的内容一样


保存工作区，如果在dev分支上，突然要切换到另外的分支上，但是工作没做完没法commit，可以使用git stash命令保存工作区，这个时候stage是干净的，切换回来的时候可以使用git stash apply/pop {stashlist}恢复


9.4 
git branch -D dev 没合并分支即可删除分支

9.6 
创建远程分支
git checkout -b dev1
git push origin dev1:dev1(最好同名，后面是远程分支名称)

拉取远程分支可以使用
git checkout -b dev1 origin/dev1
或
git checkout -t origin/dev1（应该是自动关联本地和远程了）

git remote -v 查看远程库信息
git branch -va 查看远程和本地分支

多人协作
一般是某个人完成任务：git push origin dev1 把本地提交推到远程的dev1分支，但是可能远程已经变化，可以git pull先
如果有冲突更改冲突并提交，再推送就没问题了
