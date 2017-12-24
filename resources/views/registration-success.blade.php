@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">How To Check Mail</div>

                <div class="panel-body">
                  <h1>Checking and Sending Mail</h1>
                  <h2>Webmail</h2>
                  <hr>
                  Webmail lets you check your email from any web browser. Your webmail site is:
                  <br>
                  <a href="https://box.jyroneparkeremail.space/mail" target="_blank">https://box.jyroneparkeremail.space/mail</a>
                  <br>
                  Your username is your whole email address.
                  <br>
                  <h2>Mobile/desktop apps</h2>
                  <hr>
                  Automatic configuration
                  <br>
                  iOS and OS X only: Open this configuration link on your iOS device or on your Mac desktop to easily set up mail (IMAP/SMTP), Contacts, and Calendar. Your username is your whole email address.
                  <br>
                  Manual configuration
                  <br>
                  Use the following settings when you set up your email on your phone, desktop, or other device:
                  <br>
                  Option	Value
                  <br>
                  Protocol/Method	IMAP
                  <br>
                  Mail server	box.jyroneparkeremail.space
                  <br>
                  IMAP Port	993
                  <br>
                  IMAP Security	SSL or TLS
                  <br>
                  SMTP Port	587
                  SMTP Security	STARTTLS (“always” or “required”, if prompted)
                  <br>
                  Username:	Your whole email address.
                  <br>
                  Password:	Your mail password.
                  <br>
                  In addition to setting up your email, you’ll also need to set up contacts and calendar synchronization separately.
                  <br>
                  As an alternative to IMAP you can also use the POP protocol: choose POP as the protocol, port 995, and SSL or TLS security in your mail client. The SMTP settings and usernames and passwords remain the same. However, we recommend you use IMAP instead.
                  <br>
                  <h2>Exchange/ActiveSync settings</h2>

                  On iOS devices, devices on this compatibility list, or using Outlook 2007 or later on Windows 7 and later, you may set up your mail as an Exchange or ActiveSync server. However, we’ve found this to be more buggy than using IMAP as described above. If you encounter any problems, please use the manual settings above.
                  <br>
                  Server	box.jyroneparkeremail.space
                  <br>
                  Options	Secure Connection
                  <br>
                  Your device should also provide a contacts list and calendar that syncs to this box when you use this method.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
