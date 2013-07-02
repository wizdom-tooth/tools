#!/bin/sh

### BEGIN INIT INFO
# Provides: unicorn
# Required-Start: $local_fs $remote_fs
# Required-Stop: $local_fs $remote_fs
# Default-Start: 2 3 4 5
# Default-Stop: 0 1 6
# Short-Description: starts unicorn
# Description: starts uniconr using start-stop-daemon
### END INIT INFO

set -u
set -e

APP_ROOT=/home/wiz/g/redmines/wiz
PID=$APP_ROOT/tmp/pids/unicorn.pid
RAILS_ENV=production
UNICORN_RAILS=/usr/local/lib/ruby/gems/1.9.1/gems/unicorn-4.6.3/bin/unicorn_rails
UNICORN_CONF=$APP_ROOT/config/unicorn.rb
CMD="$UNICORN_RAILS -D -E $RAILS_ENV -c $UNICORN_CONF --path /redmine"
old_pid="$PID.oldbin"

cd $APP_ROOT || exit 1

sig () {
	test -s "$PID" && kill -$1 `cat $PID`
}
oldsig () {
	test -s $old_pid && kill -$1 `cat $old_pid`
}

case $1 in
	start)
		sig 0 && echo >&2 "Already running" && exit 0
		$CMD
		;;
	stop)
		sig QUIT && exit 0
		echo >&2 "Not running"
		;;
	force-stop)
		sig TERM && 0
		echo >&2 "Not running"
		;;
	restart|reload)
		sig HUP && echo reloaded OK && exit 0
		echo >&2 "Couldn't reload, starting '$CMD' instead"
		$CMD
		;;
	upgrade)
		sig USR2 && exit 0
		echo >&2 "Couldn't upgrade, starting '$CMD' instead"
		;;
	rotate)
		sig USR1 && echo rotated logs OK && exit 0
		echo >&2 "Couldn't rotate logs" && 1
		;;
	*)
		echo >&2 "Usage $0 <start|stop|restart|upgrade|rotate|force-stop>"
		exit 1
		;;
esac

exit 0
