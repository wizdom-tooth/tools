worker_processes 8

# RAILS_ROOT を指定
working_directory "/home/wiz/g/redmines/wiz/"

#listen 8008, :tcp_nopush => true

# ソケット
# listen "/home/wiz/g/redmines/wiz/tmp/sockets/unicorn.sock", :backlog => 1
listen "/tmp/redmine.sock"
# listen 8008, :tcp_nopush => true
timeout 120

#pid File.expand_path("tmp/pids/unicorn.pid", ENV['/srv/www/redmine/redmine'])
pid File.expand_path("tmp/pids/unicorn.pid", ENV['RAILS_ROOT'])
stderr_path File.expand_path("log/unicorn.stderr.log", ENV['RAILS_ROOT'])
stdout_path File.expand_path("log/unicorn.stdout.log", ENV['RAILS_ROOT'])
#stderr_path "log/unicorn.log"
#stdout_path "log/unicorn.log"

preload_app true
before_fork do |server, worker|
    defined?(ActiveRecord::Base) and ActiveRecord::Base.connection.disconnect!
    old_pid = "#{ server.config[:pid] }.oldbin"
    unless old_pid == server.pid
        begin
            # SIGTTOU だと worker_processes が多いときおかしい気がする
            Process.kill :QUIT, File.read(old_pid).to_i
        rescue Errno::ENOENT, Errno::ESRCH
        end
    end
end
after_fork do |server, worker|
    defined?(ActiveRecord::Base) and ActiveRecord::Base.establish_connection
end
