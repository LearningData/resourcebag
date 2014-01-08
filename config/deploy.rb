set :application, 'file-server'
set :repo_url, 'git@git.learningdata.net:/srv/d_jess01/git/repositories/resourcebag.git'

# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }
set :deploy_to, '/Projects/file-server'
set :deploy_via, :remote_cache
set :scm, :git
# set :format, :pretty
# set :log_level, :debug
# set :pty, true

# set :linked_files, %w{config/database.yml}
# set :linked_dirs, %w{bin log tmp/pids tmp/cache tmp/sockets vendor/bundle public/system}

namespace :deploy do
  desc "Start application"
  task :start do
    on roles(:app) do
      execute "cd #{deploy_to}/current && forever start app.js"
    end
  end

  desc "Stop application"
  task :stop do
    on roles(:app) do
      execute "cd #{deploy_to}/current && forever stop app.js"
    end
  end

  desc 'Restart application'
  task :restart do
    on roles(:app), in: :sequence, wait: 5 do
      execute "cd #{deploy_to}/current && forever restart app.js"
    end
  end

  desc 'Npm install'
  task :npm_install do
    on roles(:app) do
      execute "cd #{deploy_to} && npm install"
    end
  end

  after :finishing, 'deploy:cleanup'
end