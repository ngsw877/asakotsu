alias ?='echo $?'
alias ll='ls -l'
alias la='ls -a'
alias c='clear'
alias e='exit'
alias h='history'
alias is='istats'
alias alig='alias |  grep'

alias brc='vi ~/.bashrc'
alias sbrc='source ~/.bashrc'
alias bali='vi ~/.bash_aliases'

### php command ###
alias phps='php -S 127.0.0.1:8000'
alias pa='php artisan'
alias pads='php artisan db:seed'
alias pam='php artisan migrate'
alias pamr='php artisan migrate:refresh'
alias pas='php artisan serve'
alias par='php artisan route:list'
alias cda='composer dump-autoload'
alias seed='composer dump-autoload && php artisan migrate:refresh --seed'

### vagrant command ###
alias vh='vagrant halt'
alias vr='vagrant reload'
alias vs='vagrant ssh'
alias vu='vagrant up'


### git command ###
alias ga='git add'
alias gb='git branch'
alias gbc='git branch --contains=HEAD'
alias gc='git commit'
alias gcm='git commit -m'
alias gd='git diff'
alias gm='git merge'
alias gmm='git merge master'
alias gco='git checkout'
alias gcob='git checkout -b'
alias gcom='git checkout master'
alias gcod='git checkout develop'
alias gs='git status'
alias grs='git restore'
alias gcl='git clean -df'
alias grc='git restore . && git clean -df'
alias gss='git stash -u'
alias gssa='git stash apply'
alias gssp='git stash pop'
alias gsss='git stash show'
alias gssl='git stash list'
alias gpo='git push origin'
alias gpod='git push origin develop'
alias gpom='git push origin master'
alias gplo='git pull origin'
alias gplod='git pull origin develop'
alias gplom='git pull origin master'
alias gl='git log'
alias glp='git log -p'
alias gl1='git log --oneline -n'


### docker command ###

alias d='docker'

#docker image
alias dp='docker pull'
alias di='docker images'
alias dil='docker image ls'
alias dirm='docker image rm'
alias drmi='docker rmi'
alias db='docker build'
alias dip='docker image prune'

#container
alias dps='docker ps'
alias dpsa='docker ps -a'
alias dsta='docker start'
alias dpa='docker pause'
alias dupa='docker unpause'
alias dsto='docker stop'
alias dr='docker run'
alias drm='docker rm'
alias dsp='docker system prune'
alias dcp='docker container prune'

#docker-compose
alias dc='docker-compose'
alias dce='docker-compose exec'
alias dcs='docker-compose stop'
alias dcu='docker-compose up -d'

### npm command ###
alias nrd='npm run dev'
alias nrw='npm run watch'
alias nrwp='npm run watch-poll'


function mkcd() {
 mkdir $@ && cd `echo $@ | sed -e "s/-[^ \f\n\r\t]*//g"`
}
