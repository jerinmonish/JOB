<h1 align="center">Job Portal System</h1>
<h3>Project Scope</h3>
<p>The application will have 3 types of users such as Admin, Employer, Employee, with role based login and authorization </p>
<p>Admin Can:</p>
<ul>
    <li>Admin can manage users (Employee, Empoyer) just with status updating to login.</li>
    <li>Can view all Jobs created by Employer.</li>
    <li>Can view users profile.</li>
</ul>

<p>Empoyer Can:</p>
    <ul>
        <li>Employer can manage jobs, create-edit-delete-view.</li>
        <li>Can view only employees list and profile.</li>
        <li>Can view, delete applied employees.</li>
        <li>Can chat with applied employees.</li>
        <li>Can view employees subscribed to his job feeds.</li>
    </ul>
    
<p>Empoyee Can:</p>
    <ul>
        <li>Employee can list, view, apply all jobs posted by employer.</li>
        <li>Once applied he cannot reapply for that same job.</li>
        <li>Can see how many views the job has got.</li>
        <li>Can see applied jobs.</li>
        <li>Can see the details like, employer has seen or replied to him.</li>
        <li>Can subscribe or unsubscribe anytime to particular employer's job posts.</li>
        <li>Can see how many employers he as subscribed to. </li>
    </ul>
    
<p>All Users Can: </p>
    <ul>
        <li>Update Profile pic and update profile details based on there role. </li>
        <li>Update Password.</li>
    </ul>

<h3>Installation Details</h3>
<ol>
    <li>After Pull, go inside project folder and composer update</li>
    <li>Now create database with name dem in phpmyadmin(mysql).</li>
    <li>Enter DB Credentials in .env file</li>
    <li>Now in terminal or cmd go inside the JOB folder and type the below following commands:</li>
        <ul>
            <li>php artisan migrate (Migrates all the Database Tables).</li>
            <li>Open terminal and go inside project directory and type sudo chmod 777 -R storage/ bootstrap/ - For permission setup in Linux</li>
            <li>Go inside public directory inside project directory in terminal and sudo chmod 777 -R assets/ - For permission setup to store image, docs files.</li>
        </ul>
    <li>Now go to browser and type the folder url.</li>
</ol>

<p>Framework used: Laravel (6.15.1)</p>

<p>For your information still it has some frontend bugs like</p>
    <ul>
        <li>while chatting with employer => employee and inverse of them, messages are not properly appended.</li>
        <li>unwanted chat links for admin and other places where its is not required.</li>
    </ul>

<p>If you find any server side bug or need to correct me, just mail me at <a href="mailto:jerinmonish007@gmail.com">jerinmonish007@gmail.com</a></p>
<p>Thanks</p>
