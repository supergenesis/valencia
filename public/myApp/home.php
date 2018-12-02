<html>
    <head>
        <title>myApp by valencia</title>
    </head>
    <body>
        Welkom!<br />

        <ul>
        {{ foreach book.name as title }}
            <li>{{ echo title }}</li>
        {{ next }}
        </ul>

    </body>
</html>