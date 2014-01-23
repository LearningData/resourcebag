set :stage, :production

set :user, 'vagrant'
set :ssh_options, {port: 2222, keys: ['~/.vagrant.d/insecure_private_key']}

role :app, %w{vagrant@localhost}
role :web, %w{vagrant@localhost}
#role :db,  %w{deploy@example.com}

server 'localhost', user: 'vagrant', roles: %w{web app}, my_property: :my_value