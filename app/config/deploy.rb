set :application, "scorekeeper"
#set :domain,      "#{application}.com"
set :domain,      "#{application}"
set :deploy_to,   "/var/www/#{domain}"
set :app_path,    "app"
set :user,"pi"


#set :repository,  "#{domain}:/var/repos/#{application}.git"
set :repository,  "https://github.com/robhaverkort/scorekeeper.git"
set :scm,         :git
set :scm_username,"robhaverkort"

# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

#role :web,        domain                         # Your HTTP server, Apache/etc
#role :app,        domain, :primary => true       # This may be the same as your `Web` server
role :web,        "192.168.0.12"                         # Your HTTP server, Apache/etc
role :app,        "192.168.0.12", :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL
