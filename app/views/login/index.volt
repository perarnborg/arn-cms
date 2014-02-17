
{{ content() }}

<h1>Login</h1>

{{ form('login/start', 'class': 'form-inline') }}
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="email">Username/Email</label>
            <div class="controls">
                {{ text_field('email', 'size': "30", 'class': "input-xlarge") }}
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="password">Password</label>
            <div class="controls">
                {{ password_field('password', 'size': "30", 'class': "input-xlarge") }}
            </div>
        </div>
        <div class="form-actions">
            {{ submit_button('Login', 'class': 'button') }}
        </div>
    </fieldset>
</form>
