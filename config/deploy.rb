set :application, 'file-server'
set :repo_url, 'git@git.learningdata.net:resourcebag.git'
# set :repo_url, 'file:///Users/edgar/Projects/file-server/.git'

# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }
set :deploy_to, '/home/azureuser/resourcebag'
set :deploy_via, :copy
set :scm, :git
set :use_sudo, false
set :pty, true
set :ssh_options, {:forward_agent => true, keys: [File.join(ENV["HOME"], ".ssh", "id_rsa")]}
# set :format, :pretty
# set :log_level, :debug
# set :scm_verbose, true

# set :linked_files, %w{config/database.yml}
# set :linked_dirs, %w{bin log tmp/pids tmp/cache tmp/sockets vendor/bundle public/system}

namespace :deploy do
  desc "Start application"
  task :start do
    on roles(:web) do
      execute "cd #{deploy_to}/current && forever start app.js"
    end
  end

  desc "Stop application"
  task :stop do
    on roles(:web) do
      execute "cd #{deploy_to}/current && forever stop app.js"
    end
  end

  desc 'Restart application'
  task :restart do
    on roles(:web), in: :sequence, wait: 5 do
      execute "cd #{deploy_to}/current && npm install"
      execute "cd #{deploy_to}/current && forever restart app.js"
    end
  end

  desc 'Npm install'
  task :npm_install do
    on roles(:web), in: :sequence do
      execute "cd #{deploy_to}/current && npm install"
    end
  end

  after "deploy", "deploy:npm_install"
end