@component('mail::message')
# Hello {{ $name }},

#### Welcome to my very owned Online Exam App! 
##### Here is your credentials:
###### Email: {{ $email }}
###### Password: {{ $password }}

[![N|Solid](https://cdn3.iconfinder.com/data/icons/e-learning-flat-education-technology/512/Online_tests-512.png)]

@component('mail::button', ['url' => 'https://purist-online-exam-app.test/'])
Try it now!
@endcomponent

Thanks,<br>
Purist online exam app
@endcomponent
