<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: "Lato", sans-serif;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f1f1f1;
            padding: 10px;
            color: black;
            position: fixed;
            width: 100%;
            height: 5%;
            top: 0;
            z-index: 1000;
            margin-bottom: 0;
            /* Menghilangkan margin-bottom pada navbar */
        }

        .navbar span {
            margin-left: 220px;
            /* Sesuaikan nilai margin-left untuk menggeser ke kanan */
        }

        .navbar a {
            color: black;
            text-decoration: none;
            margin-right: 20px;
        }

        .sidebar {
            margin: 0;
            padding: 0;
            width: 200px;
            background-color: #f1f1f1;
            position: fixed;
            height: 100%;
            overflow: auto;
            top: 50px;
            /* Menggeser sidebar agar tidak tumpang tindih dengan navbar */
        }

        .sidebar a {
            display: block;
            color: black;
            padding: 16px;
            text-decoration: none;
        }

        .sidebar a.active {
            background-color: black;
            color: white;
        }

        .sidebar a:hover:not(.active) {
            background-color: #555;
            color: white;
        }

        div.content {
            margin-top: 50px;
            /* Menggeser konten agar tidak tertutupi oleh navbar */
            margin-left: 200px;
            padding: 1px 16px;
            height: 1000px;
        }

        @media screen and (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                top: 0;
                /* Kembalikan posisi top menjadi 0 */
            }

            .sidebar a {
                float: left;
            }

            div.content {
                margin-left: 0;
            }
        }

        @media screen and (max-width: 400px) {
            .sidebar a {
                text-align: center;
                float: none;
            }
        }
    </style>

</head>

<body>

    <div class="navbar">
        <span>Welcome Back, John Doe</span>
        <a href="#profile">Profile</a>
    </div>

    <div class="sidebar">
        <a class="active" href="#home">Home</a>
        <a href="#news">Users</a>
        <a href="#contact">Transactions</a>
        <a href="#about">Logout</a>
    </div>

    <div class="content">
        @yield('manage_users')
    </div>

</body>

</html>
