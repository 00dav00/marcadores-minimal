set :application, 'marcadores'
set :repo_url, 'git@github.com:00dav00/marcadores-minimal.git'

set :deploy_to, "/var/projects/#{fetch(:application)}"
set :branch, ENV['BRANCH'] || 'master'
set :scm, :git

set :stages, %w(staging production)
set :default_stage, :staging
set :user, 'operator'
set :keep_releases, 5
set :log_level, :debug
set :tmp_dir, "#{fetch(:deploy_to)}/tmp"

set :laravel_server_user, 'operator'
set :laravel_version, 5.1
set :laravel_artisan_flags, "--env=#{fetch(:stage)}"
set :laravel_upload_dotenv_file_on_deploy, true

set :laravel_5_linked_dirs, [
  'storage'
]

set :laravel_5_acl_paths, [
  'bootstrap/cache',
  'storage',
  'storage/app',
  'storage/app/public',
  'storage/framework',
  'storage/framework/cache',
  'storage/framework/sessions',
  'storage/framework/views',
  'storage/logs'
]

namespace :deploy do
  desc "Build"
  after :updated, :build do
    on roles(:app) do
      within release_path  do
        execute :chmod, "u+x artisan" # make artisan executable
        execute :php, "artisan migrate" # run migrations
        execute "cd #{release_path} && npm install --quiet"
        execute "cd #{release_path} && node_modules/bower/bin/bower install --quiet"
        execute "cd #{release_path} && node_modules/.bin/gulp"
      end
    end
  end

  desc "Restart"
  task :restart do
    on roles(:app) do
      within release_path  do
        execute :chmod, "-R 777 app/storage/cache"
        execute :chmod, "-R 777 app/storage/logs"
        execute :chmod, "-R 777 app/storage/meta"
        execute :chmod, "-R 777 app/storage/sessions"
        execute :chmod, "-R 777 app/storage/views"
      end
    end
  end
end
