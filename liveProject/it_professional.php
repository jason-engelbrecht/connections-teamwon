<?php
$page_title = 'Create Your Account';
include('includes/header.html');
?>

<!--Start of html - IT professional create account form-->
<div class="container">
    <div class="col-sm-8 offset-2 justify-content-center">
        <div class="col-sm-12 text-center">
            <h1>Create Your Account</h1>
        </div>
        <form class="form-group" action="#" method="post">
            <fieldset class="form-group">
                <div class="form-row col">
                    <div class="form-group col-md-6">
                        <label for="first_name" class="required">First name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" size="25" maxlength="25" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name" class="required">Last name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" size="25" maxlength="25" required>
                    </div>
                </div>
                <div class="form-group col">
                    <label for="email" class="required">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" size="256" maxlength="256" required>
                </div>
                <div class="form-group col">
                    <label for="password" class="required">Preferred password</label>
                    <div class="form-row">
                        <div class="col">
                            <input type="password" class="form-control" name="password" id="password" size="20" maxlength="20" required>
                        </div>
                        <div class="col">
                            <small id="passwordHelp" class="form-text text-muted col">At least 10 characters</small>
                        </div>
                    </div>
                </div>
                <div class="form-group col">
                    <label for="company_name">Company -OR- Organization name</label>
                    <input type="text" class="form-control" name="company_name" size="80" maxlength="80" id="company_name">
                </div>
                <div class="form-group col">
                    <label for="job_title">Job title</label>
                    <input type="text" class="form-control" name="job_title" id="job_title" size="40" maxlength="40">
                </div>
                <div class="form-group col">
                    <label for="bio">Short biography about you (third-person)</label>
                    <textarea class="form-control" name="bio" id="bio" maxlength="560" placeholder="Optional, Limit 560 characters"></textarea>
                </div>
                <div class="form-group col">
                    <label for="expertise" class="required">Area of expertise you are comfortable speaking on</label>
                    <small id="expertiseHelp" class="form-text text-muted"><em>Enter each area of expertise separated by ", "</em></small>
                    <input type="text" class="form-control" name="expertise" id="expertise">
                </div>
            </fieldset>
            <fieldset class="form-group col">
                <label class="required">Format you feel comfortable presenting</label>
                <small id="formatHelp" class="form-text text-muted"><em>Check at least one -OR- all that apply</em></small>
                <div class="form-check text-left">
                    <input class="form-check-input" type="checkbox" name="formats[]" id="qa" value="Q & A / Interview">
                    <label class="form-check-label" for="qa">Q & A / Interview</label>
                </div>
                <div class="form-check text-left">
                    <input class="form-check-input" type="checkbox" name="formats[]" id="formal" value="Formal Presentation / Lecture">
                    <label class="form-check-label" for="formal">Formal Presentation / Lecture</label>
                </div>
                <div class="form-check text-left">
                    <input class="form-check-input" type="checkbox" name="formats[]" id="panel" value="Panel">
                    <label class="form-check-label" for="panel">Panel</label>
                </div>
                <div class="form-check text-left">
                    <input class="form-check-input" type="checkbox" name="formats[]" id="workshop" value="Workshop">
                    <label class="form-check-label" for="workshop">Workshop</label>
                </div>
            </fieldset>
            <div class="form-group col">
                <div class="col text-center">
                    <button type="submit" class="btn" value="Submit">Create Account</button>
                </div>
            </div>

            <!--TODO: required **OPEN QUESTION** checkbox has at least one value?, capture inputs - validate php -->
        </form>
    </div>
</div>

<?php
include('includes/footer.html');
?>