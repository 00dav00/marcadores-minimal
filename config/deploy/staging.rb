set :stage, :staging
set :laravel_dotenv_file, './.staging.env'

server 'staging.marcadores.com',
  user: fetch(:user),
  roles: %w(app web db),
  port: 2022

set :ssh_options, forward_agent: true
