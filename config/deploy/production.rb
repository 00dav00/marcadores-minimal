set :stage, :production
set :laravel_dotenv_file, './.production.env'

server 'marcadores.dataprensa.com',
  user: fetch(:user),
  roles: %w(app web db),
  port: 22

set :ssh_options, forward_agent: true
