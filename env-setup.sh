#!/bin/bash

case "$1" in
    init)
        echo "Installing VirtualBox, Vagrant, packer, git ..."
        
        sudo apt-get update
        sudo apt-get install -y virtualbox git vagrant packer
        
        echo "Removing old versions of Docker ..."
        
        sudo apt-get remove docker docker-engine docker.io containerd runc
        
        echo "Installing Docker ..."
        
        sudo apt-get install -y apt-transport-https ca-certificates curl gnupg-agent software-properties-common

        curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -

        sudo apt-key fingerprint 0EBFCD88

        sudo add-apt-repository \
            "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
            $(lsb_release -cs) \
            stable"

        sudo apt-get update

        sudo apt-get install -y docker-ce docker-ce-cli containerd.io 

        echo "Installing Docker machine ..."

        base=https://github.com/docker/machine/releases/download/v0.16.0 &&
            curl -L $base/docker-machine-$(uname -s)-$(uname -m) >/tmp/docker-machine &&
            sudo mv /tmp/docker-machine /usr/local/bin/docker-machine &&
            chmod +x /usr/local/bin/docker-machine
        
        docker-machine version

        echo "Installing Docker-compose ..."

        sudo curl -L "https://github.com/docker/compose/releases/download/1.25.3/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

        sudo chmod +x /usr/local/bin/docker-compose

        docker-compose --version
        ;;
    run)
        sudo docker-compose up -d
        ;;
    rm)
        docker-compose rm -f
        ;;
    *)
        cat <<HELP;;
Usage:
$0 init: install all necessary tools and packages for labs : git, vagrant, docker, docker machine, docker-compose...
$0 run: run the environment
$0 rm: discard the environment
HELP
esac
