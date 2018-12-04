<html>
    <head>
        <title>myApp by valencia</title>
    </head>
    <body>
        Welkom!<br />

        <ul>
        {{ for $title in $book.name }}
            <li>{{ echo $title }}</li>
        {{ endfor }}
        </ul>

    </body>
</html>