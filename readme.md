SecureCloud |  Code Competition 03/2017 IT-Talents
==============

> Dieses Projekt ist das Ergebnis der Code Competition 03/2017 von [it-talents](https://www.it-talents.de/foerderung/code-competition/code-competition-03-2017).

Das Projekt setzt auf das umfangreiche PHP-Framework [Laravel](https://laravel.com/) auf.  
Im Frontend kommt das JavaScript-Framework [Vue.js](https://vuejs.org/) im Zusammenspiel mit [Vue Material](https://vuematerial.github.io/#/), sowie ein wenig [jQuery](http://jquery.com/) zum Einsatz.  

- - -

## Systemanforderungen

* PHP >= 7.0
* MySQL >= 5.6

- - - 

## Installation

* [Vagrant](https://www.vagrantup.com/), [Virtualbox](https://www.virtualbox.org/), [Laravel Homestead](https://laravel.com/docs/5.4/homestead) installieren  
* Homestead.yaml anpassen  
* VM hochfahren mit `vagrant up`  
* Per ssh verbinden mit `vagrant ssh`  
* In der VM (im Projekt-Root) folgende Befehle ausführen:  

```sh
composer install  
php artisan migrate  
```

- - - 

## Benutzung

* Um einen Account anzulegen kann die Route `/register` besucht werden  
* Es muss ein Bild aufgenommen, ein Username, sowie ein Passwort eingegeben werden um die Registrierung abzuschließen  
* Anschließend wird man automatisch eingeloggt und kann die **SecureCloud** nutzen.  
* Diese besitzt einige Grundfunktion wie das Hochladen, Teilen und Löschen von Dateien.  


* Um sich später wieder einzuloggen, wird man automatisch auf die Seite `/login` weitergeleitet, wenn die Session auf dem Server abgelaufen ist  
* Nach Eingabe seinen Usernames und Aufnehmen des Bildes wird die Microsoft FaceApi angesprochen um zu vergleichen ob die Person sich authentifizieren darf  
* Bei mehr als 75% Übereinstimmung wird man sofort eingeloggt  
* Bei Übereinstimmung zwischen 50% und 75% wird zusätzlich das Passwort abgefragt um sicherzustellen, dass es sich um den richtigen Nutzer handelt  
* Bei Übereinstimmung von unter 50% wird der Login-Vorgang abgebrochen  

- - -

## Geplante Features

Da die Zeit sehr knapp war, konnte ich einige Features nicht umsetzen:
* Download von mehreren Dateien gleichzeitig im Userbereich (als .zip File)  
* Dateivorschau im Userbereich  
* Anlegen von `.md` oder `.txt` Dateien direkt im Browser  
* Diverse Usability-Verbesserungen im Authentifizierungs-Prozess  
* Besseres Responsive-Design der gesamten Seite  