[![de](https://img.shields.io/badge/lang-de-yellow.svg)](https://github.com/oberator/ansible_goneuland_traefik_v3/blob/main/readme.de.md)

# Automated Server Provisioning with Ansible

This repository contains an Ansible playbook for automated server provisioning, inspired by [@Psycho0verload](https://github.com/Psycho0verload/traefik-crowdsec-stack) and [Goneuland](https://goneuland.de/traefik-v3-installation-konfiguration-und-crowdsec-security/8/). It includes roles for setting up common server configurations, Docker, SSH, firewall, Git, and CrowdSec.

**Note:** This repository is intended to work with Debian 11 & 12 distributions. Using other distributions may result in errors due to the Debian-oriented apt repository.

![Debian 11 - Testing](https://img.shields.io/badge/Debian_11_(Bullseye)-10--02--2025-A81D33?logo=debian&logoColor=white)
![Debian 12 - Testing](https://img.shields.io/badge/Debian_12_(Bookworm)-12--05--2025-A81D33?logo=debian&logoColor=white)

## Directory Structure

```plaintext
group_vars/
    all.yml
hosts.ini
playbook.yml
roles/
    cleanup/
        tasks/
            main.yml
    common/
        tasks/
            main.yml
    crowdsec/
        tasks/
            main.yml
    crowdsec_firewall_bouncer/
        tasks/
            main.yml
    docker/
        tasks/
            main.yml
    firewall/
        tasks/
            main.yml
    git/
        tasks/
            main.yml
    ssh/
        tasks/
            main.yml
```

## Inventory

The `hosts.ini` file defines the inventory of servers to be managed:

```ini
[servers]
yourservername ansible_host=12.345.678.99 ansible_user=root ansible_become=true
```

## Playbook

The main playbook is defined in `playbook.yml` and will execute all role tasks on every server which are defined in the `hosts.ini`.

## Roles

### Common

The common role performs basic server setup tasks such as updating packages, setting the timezone, and creating an admin user.

### SSH

The ssh role configures SSH settings, including changing the SSH port, setting up key authentication, and disabling root password authentication.

### Docker

The docker role installs Docker, its dependencies, and configures Docker to start on boot.

### Firewall

The firewall role installs and configures UFW with basic rules to secure the server.

### Git

The git role installs Git and configures global Git settings.

### CrowdSec

The crowdsec role sets up CrowdSec for intrusion detection and prevention, including the installation of required packages and configuration files.

### CrowdSec Firewall Bouncer

The crowdsec_firewall_bouncer role installs and configures the CrowdSec firewall bouncer to work with UFW.

### Cleanup

The cleanup role performs final cleanup tasks, such as removing unnecessary packages and enabling UFW.

## Variables

The `group_vars/all.yml` file defines global variables used across roles. Descriptions of each variable are available in the comments within the file. 

## Usage

To use this Ansible playbook, follow these steps:

1. **Clone the Repository**: Clone this repository to your local machine where Ansible is installed.
2. **Configure Inventory**: Copy the `hosts.ini.sample` file to `hosts.ini` and edit it to include the details of the servers you want to manage.
3. **DNS Configuration**: Ensure that the DNS A-Record for your domain is correctly set up.
4. **Set Variables**: Copy the `group_vars/all.yml.sample` file to `group_vars/all.yml` and update it with your desired configuration settings.
5. **Run the Playbook**: Execute the playbook from your local machine (not on the remote server) using the following command:

    ```sh
    ansible-playbook -i hosts.ini playbook.yml -kK
    ```

This will prompt you for the SSH password and the privilege escalation password (if required), and then proceed to configure the servers as specified in the playbook.

## License

This project is licensed under the MIT License.
