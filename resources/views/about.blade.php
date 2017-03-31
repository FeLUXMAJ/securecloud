@extends('master')

@section('content')

    <link rel="stylesheet" href="https://stackedit.io/res-min/themes/base.css"/>
    <div class="container">
        <h1 id="securecloud-code-competition-032017-it-talents">SecureCloud | Code Competition 03/2017 IT-Talents</h1>
        <blockquote>
            <p>Dieses Projekt ist das Ergebnis der Code Competition 03/2017 von <a
                        href="https://www.it-talents.de/foerderung/code-competition/code-competition-03-2017">it-talents</a>.
            </p>
        </blockquote>
        <p>Das Projekt setzt auf das umfangreiche PHP-Framework <a href="https://laravel.com/">Laravel</a> auf.
            <br> Im Frontend kommt das JavaScript-Framework <a href="https://vuejs.org/">Vue.js</a> im Zusammenspiel mit
            <a href="https://vuematerial.github.io/#/">Vue Material</a>, sowie ein wenig <a href="http://jquery.com/">jQuery</a>
            zum Einsatz.
        </p>
        <hr>
        <h2 id="systemanforderungen">Systemanforderungen</h2>
        <ul>
            <li>PHP &gt;= 7.0</li>
            <li>MySQL &gt;= 5.6</li>
        </ul>
        <hr>
        <h2 id="installation">Installation</h2>
        <ul>
            <li><a href="https://www.vagrantup.com/">Vagrant</a>, <a href="https://www.virtualbox.org/">Virtualbox</a>,
                <a href="https://laravel.com/docs/5.4/homestead">Laravel Homestead</a> installieren
            </li>
            <li>Homestead.yaml anpassen</li>
            <li>VM hochfahren mit <code>vagrant up</code>
            </li>
            <li>Per ssh verbinden mit <code>vagrant ssh</code>
            </li>
            <li>In der VM (im Projekt-Root) folgende Befehle ausführen:</li>
        </ul>
        <pre class="prettyprint"><p class="language-sh hljs cmake">composer <span class="hljs-keyword">install</span>
php artisan migrate  </p></pre>
        <hr>
        <h2 id="benutzung">Benutzung</h2>
        <ul>
            <li>Um einen Account anzulegen kann die Route <code>/register</code> besucht werden</li>
            <li>Es muss ein Bild aufgenommen, ein Username, sowie ein Passwort eingegeben werden um die Registrierung
                abzuschließen
            </li>
            <li>Anschließend wird man automatisch eingeloggt und kann die <strong>SecureCloud</strong> nutzen.</li>
            <li>
                <p>Diese besitzt einige Grundfunktion wie das Hochladen, Teilen und Löschen von Dateien. </p>
            </li>
            <li>
                <p>Um sich später wieder einzuloggen, wird man automatisch auf die Seite <code>/login</code>
                    weitergeleitet, wenn die Session auf dem Server abgelaufen ist </p>
            </li>
            <li>Nach Eingabe seinen Usernames und Aufnehmen des Bildes wird die Microsoft FaceApi angesprochen um zu
                vergleichen ob die Person sich authentifizieren darf
            </li>
            <li>Bei mehr als 75% Übereinstimmung wird man sofort eingeloggt</li>
            <li>Bei Übereinstimmung zwischen 50% und 75% wird zusätzlich das Passwort abgefragt um sicherzustellen, dass
                es sich um den richtigen Nutzer handelt
            </li>
            <li>Bei Übereinstimmung von unter 50% wird der Login-Vorgang abgebrochen</li>
        </ul>
        <hr>
        <h2 id="geplante-features">Geplante Features</h2>
        <p>Da die Zeit sehr knapp war, konnte ich einige Features nicht umsetzen:</p>
        <ul>
            <li>Download von mehreren Dateien gleichzeitig im Userbereich (als .zip File)</li>
            <li>Dateivorschau im Userbereich</li>
            <li>Anlegen von <code>.md</code> oder <code>.txt</code> Dateien direkt im Browser</li>
            <li>Diverse Usability-Verbesserungen im Authentifizierungs-Prozess</li>
            <li>Besseres Responsive-Design der gesamten Seite</li>
        </ul>
    </div>

@stop