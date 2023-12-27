 <!-- Settings Side Menu -->
 <section>
     <a href='accountSettings.php'>
         <h1>My Settings</h1>
         <h2>at <b>Edmonton Public Library</b></h2>
     </a>
     <h3>Account Information</h3>
     <?php
        function currentPage($page)
        {
            if (basename($_SERVER['PHP_SELF']) === $page) echo "class='currentSetting'";
        }
        ?>
     <nav>
         <ul>
             <li <?php currentPage('changeEmail.php') ?>><a href='changeEmail.php'>Email Address</a></li>
             <li <?php currentPage('changeUsername.php') ?>><a href='changeUsername.php'>Username</a></li>
             <li <?php currentPage('changePassword.php') ?>><a href='changePassword.php'>Password</a></li>
             <li <?php currentPage('changePhoneNum.php') ?>><a href='changePhoneNum.php'>Phone Number</a></li>
         </ul>
     </nav>
 </section>