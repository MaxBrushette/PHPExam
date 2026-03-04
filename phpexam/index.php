<?php require "includes/header.php" ?>
    <body>
        <main>
            <header>
                <h1>Event Registration</h1>
            </header>
            <section>
                <!--This is just the initial table so you can enter in information to the database. Uses POST. -->
                <form action="process.php" method="post">
                    <fieldset>
                        <legend>Registration Form</legend>
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" id="firstName" name="firstName" class="form-control" required/>
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" id="lastName" name="lastName" class="form-control" required/>
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control" required/>

                        <p>
                            <button type="submit" class="btn btn-outline-primary">Submit</button>
                            <button type="reset" class="btn btn-outline-danger">Reset</button>
                        </p>
                    </fieldset>
                </form>
            </section>
        </main>
        <?php include "includes/footer.php" ?>
    </body>
</html>