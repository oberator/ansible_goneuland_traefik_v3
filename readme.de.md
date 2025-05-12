[![en](https://img.shields.io/badge/lang-en-red.svg)](https://github.com/oberator/ansible_goneuland_traefik_v3/blob/main/readme.md)

# Automatisierte Serverbereitstellung mit Ansible

Dieses Repository enthält ein Ansible-Playbook für die automatisierte Serverbereitstellung, inspiriert von [@Psycho0verload](https://github.com/Psycho0verload/traefik-crowdsec-stack) und [Goneuland](https://goneuland.de/traefik-v3-installation-konfiguration-und-crowdsec-security/8/). Es umfasst Rollen für die Einrichtung gängiger Serverkonfigurationen, Docker, SSH, Firewall, Git und CrowdSec.

**Hinweis:** Dieses Repository ist für die Verwendung mit Debian 11- und 12-Distributionen vorgesehen. Die Verwendung anderer Distributionen kann zu Fehlern führen, da das apt-Repository auf Debian ausgerichtet ist.

![Debian 11 - Testing](https://img.shields.io/badge/Debian_11_(Bullseye)-10--02--2025-A81D33?logo=debian&logoColor=white)
![Debian 12 - Testing](https://img.shields.io/badge/Debian_12_(Bookworm)-12--05--2025-A81D33?logo=debian&logoColor=white)

## Verzeichnisstruktur

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

## Inventar

Die Datei `hosts.ini` definiert das Inventar der zu verwaltenden Server:

```ini
[servers]
yourservername ansible_host=12.345.678.99 ansible_user=root ansible_become=true
```

## Playbook

Das Haupt-Playbook ist in `playbook.yml` definiert und führt alle Rollenaufgaben auf jedem Server aus, die in der Datei `hosts.ini` definiert sind.

## Rollen

### Common

Die Rolle "common" führt grundlegende Servereinrichtungsaufgaben aus, wie das Aktualisieren von Paketen, das Festlegen der Zeitzone und das Erstellen eines Admin-Benutzers.

### SSH

Die Rolle "ssh" konfiguriert SSH-Einstellungen, einschließlich der Änderung des SSH-Ports, der Einrichtung der Schlüsselauthentifizierung und der Deaktivierung der Root-Passwortauthentifizierung.

### Docker

Die Rolle "docker" installiert Docker, dessen Abhängigkeiten und konfiguriert Docker so, dass es beim Booten startet.

### Firewall

Die Rolle "firewall" installiert und konfiguriert UFW mit grundlegenden Regeln, um den Server abzusichern.

### Git

Die Rolle "git" installiert Git und konfiguriert globale Git-Einstellungen.

### CrowdSec

Die Rolle "crowdsec" richtet CrowdSec für die Erkennung und Verhinderung von Eindringlingen ein, einschließlich der Installation erforderlicher Pakete und Konfigurationsdateien.

### CrowdSec Firewall Bouncer

Die Rolle "crowdsec_firewall_bouncer" installiert und konfiguriert den CrowdSec-Firewall-Bouncer zur Zusammenarbeit mit UFW.

### Cleanup

Die Rolle "cleanup" führt abschließende Bereinigungsaufgaben aus, wie das Entfernen unnötiger Pakete und das Aktivieren von UFW.

## Variablen

Die Datei `group_vars/all.yml` definiert globale Variablen, die in allen Rollen verwendet werden. Beschreibungen jeder Variablen sind in den Kommentaren innerhalb der Datei verfügbar.

## Verwendung

Um dieses Ansible-Playbook zu verwenden, führen Sie die folgenden Schritte aus:

1. **Repository klonen**: Klonen Sie dieses Repository auf Ihren lokalen Rechner, auf dem Ansible installiert ist.
2. **Inventar konfigurieren**: Kopieren Sie die Datei `hosts.ini.sample` nach `hosts.ini` und bearbeiten Sie sie, um die Details der Server einzutragen, die Sie verwalten möchten.
3. **DNS-Konfiguration**: Stellen Sie sicher, dass der DNS-A-Record für Ihre Domain korrekt eingerichtet ist.
4. **Variablen festlegen**: Kopieren Sie die Datei `group_vars/all.yml.sample` nach `group_vars/all.yml` und aktualisieren Sie sie mit Ihren gewünschten Konfigurationseinstellungen.
5. **Playbook ausführen**: Führen Sie das Playbook von Ihrem lokalen Rechner (nicht auf dem Remote-Server) mit folgendem Befehl aus:

    ```sh
    ansible-playbook -i hosts.ini playbook.yml -kK
    ```

Sie werden aufgefordert, das SSH-Passwort und das Passwort für die Privilegienerhöhung (falls erforderlich) einzugeben und konfiguriert dann die Server gemäß den im Playbook angegebenen Spezifikationen.

## Lizenz

Dieses Projekt ist unter der MIT-Lizenz lizenziert.