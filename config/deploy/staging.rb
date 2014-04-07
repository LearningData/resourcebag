set :stage, :staging

role :web, %w{azureuser@resourcebag.cloudapp.net}

# set :ssh_options, { port: 3536, forward_agent: true, auth_methods: %w(password)}

# server 'azureuser@137.116.242.92 -p', user: 'azureuser', roles: %w{web}


server 'resourcebag.cloudapp.net',
  user: 'azureuser',
  roles: %w{app},
  ssh_options: {
    port: 3536,
    user: 'azureuser',
    forward_agent: false,
    keys: [File.join(ENV["HOME"], ".ssh", "id_rsa")]
  }