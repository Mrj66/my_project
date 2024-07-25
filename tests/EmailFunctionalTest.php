<?php

namespace App\Tests\EmailFunctionalTest;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailFunctionalTest extends WebTestCase
{
    public function testContactFormSubmission()
    {
        $client = static::createClient();

        // Visit the contact form page
        $crawler = $client->request('GET', '/assistance');

        // Assert that the response is successful
        $this->assertResponseIsSuccessful();

        // Assert that the form exists
        $this->assertGreaterThan(0, $crawler->filter('form')->count(), 'Form not found on page');

        // Debug: Output the HTML of the page to check if the form is present
        file_put_contents('debug.html', $crawler->html());

        // Find the form and submit it
        try {
            $form = $crawler->selectButton('Submit')->form();
            $form['contact[email]'] = 'junioradcyus@gmail.com';
            $form['contact[sujet]'] = 'Test Subject';
            $form['contact[message]'] = 'This is a test message.';

            // Submit the form
            $client->submit($form);

            // Assert that the form submission was successful
            $this->assertResponseRedirects('/menu');

            // Get the email from the profiler
            if ($profile = $client->getProfile()) {
                $mailCollector = $profile->getCollector('mailer');
                $this->assertEmailCount(1);

                $email = $this->getMailerMessage();

                $this->assertEmailHeaderSame($email, 'From', 'qs2@flipo-richir.com');
                $this->assertEmailHeaderSame($email, 'To', 'junioradcyus@gmail.com');
                $this->assertEmailHeaderSame($email, 'Subject', 'Test Subject');
                $this->assertEmailTextBodyContains($email, 'This is a test message.');
            } else {
                $this->fail('Profiler is not enabled');
            }
        } catch (\InvalidArgumentException $e) {
            $this->fail('Form or button not found: ' . $e->getMessage());
        }
    }
}
