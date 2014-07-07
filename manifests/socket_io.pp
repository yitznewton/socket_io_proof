package {'openssh-server':}
package {'git-core':}
package {'build-essential':}
package {'gcc':}
package {'tree':}
package {'rabbitmq-server':}
package {'sqlite3':}
package {'php5-dev':}
package {'php5-cli':}
package {'php5-sqlite':}
package {'nodejs':}
package {'npm':}
exec {'/vagrant/install.sh':
    require => [
        Package['sqlite3'],
        Package['php5-cli'],
        Package['git-core'],
        Package['npm']
    ]
}
