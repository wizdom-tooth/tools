worker_processes 8
working_directory "/home/wiz/g/redmines/wiz/"
listen "/tmp/redmine.sock"
timeout 30
pid File.expand_path("tmp/pids/unicorn.pid", ENV['RAILS_ROOT'])
stderr_path File.expand_path("log/unicorn.log", ENV['RAILS_ROOT'])
stdout_path File.expand_path("log/unicorn.log", ENV['RAILS_ROOT'])

#preload_app true
#GC.respond_to?(:copy_on_write_friendly=) and
#  GC.copy_on_write_friendly = true

before_fork do |server, worker|
  defined?(ActiveRecord::Base) and
    ActiveRecord::Base.connection.disconnect!
end
 
after_fork do |server, worker|
  defined?(ActiveRecord::Base) and
    ActiveRecord::Base.establish_connection
end
