Quelltext der aktuellen [Play! Pokémon NRW Website](https://www.pop-rhein-ruhr.de/).
Falls du daran mitarbeiten möchtest die Website zu verbessern und weitere Fragen hast die hier nicht beantwortet werden, melde dich einfach in unserem Community Discord Server!

## Anleitung

Folgende Software muss installiert sein:
* [php](https://www.php.net/downloads)
* [Composer](https://getcomposer.org/download/)
* [MariaDB](https://mariadb.org/) oder MySQL
* [Node.js](https://nodejs.org/) inkl. npm

Zusätzlich ist [phpMyAdmin](https://www.phpmyadmin.net/) oder ein vergleichbares Datenbanktool empfehlenswert.  
[Apache](https://httpd.apache.org/) ist ebenfalls empfehlenswert und bietet ein paar Vorteile gegenüber dem integrierten Webserver, kann allerdings zusätzliche Konfiguration erfordern. 

Als Windows Nutzer ist [XAMPP](https://www.apachefriends.org/) eine unkomplizierte Methode um das meiste davon abzudecken. Auf Mac kannst du auch alles per Homebrew installieren.

Nachdem du das Projekt heruntergeladen hast, installiere mit `composer install` und `npm ci` die benötigten Dependencies, erstelle dann mit `npm run build` die benötigten js & css Dateien, und benenne `.env.example` um in `.env`. Wenn du Apache als Webserver benutzt, passe entsprechend den Wert von APP_URL an.

Zuletzt muss noch die Datenbank angelegt werden. Eine importierbare sql Datei mit der kompletten Datenbankstruktur und ein paar Beispieldaten kannst du [hier](https://gist.github.com/link--11/abdc1a65efd7036e03e671480de78244) finden. Falls du nicht XAMPP benutzt, sind eventuell die Zugangsdaten zur Datenbank anders und müssen noch in `.env` angepasst werden.

Anschließend kannst du entweder mit `php artisan serve` oder über Apache den Webserver starten und die lokale Version der Website im Browser aufrufen (standardmäßig http://localhost:8000).

Falls du an den javascript oder css/sass Dateien arbeitest, solltest du währenddessen über `npm run dev` den Vite Server laufen lassen. Dadurch werden beim Speichern einer Datei die Änderungen im Browser sofort übernommen (HMR).

## Projektüberblick

Die Website benutzt [Laravel](https://laravel.com/) als framework. Laravel übernimmt Aufgaben wie [Routing](https://laravel.com/docs/10.x/routing), erleichtert das Arbeiten mit der [Datenbank](https://laravel.com/docs/10.x/eloquent), und stellt eine [templating engine](https://laravel.com/docs/10.x/blade) zur Verfügung. Falls du mit Laravel oder generell php frameworks noch nicht vertraut bist, ist es empfehlenswert die offizielle Dokumentation durchzulesen.

Der öffentliche Teil der Website benutzt blade Dateien mit vanilla javascript und sass. Du findest diese alle im `resources` Ordner. Der Code zum Abrufen der Datenbank sowie anderer php Code sind im `app` Ordner zu finden, am wichtigsten sind dabei `Http` und `Models`. Routing ist in `routes/web.php` definiert.

Der Admin Teil der Website hingegen basiert auf [Laravel Breeze](https://laravel.com/docs/10.x/starter-kits#laravel-breeze) und benutzt Alpine.js sowie tailwindcss anstelle von vanilla js und sass. Die Dateien sind in `resources/views/admin` und `resources/views/components` zu finden und teilweise mit nur wenigen Änderungen übernommen, vor allen die welche das Accountsystem betreffen. Die dazugehörigen php Dateien befinden sich in den `Admin` und `Auth` Unterordnern von `app/Http/Controllers`.
