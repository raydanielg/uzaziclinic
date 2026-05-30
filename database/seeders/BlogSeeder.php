<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $posts = [
            [
                'title' => 'Understanding Your Reproductive Health: A Complete Guide',
                'slug' => 'understanding-reproductive-health-guide',
                'category' => 'Reproductive Health',
                'excerpt' => 'Learn about the essential aspects of reproductive health, why it matters, and how to take charge of your well-being at every stage of life.',
                'content' => "<p>Reproductive health is a fundamental aspect of overall well-being that affects individuals and families at every stage of life. At UzaziClinic, we believe that understanding your body is the first step toward making informed health decisions.</p>

<h5>What is Reproductive Health?</h5>
<p>Reproductive health refers to the condition of male and female reproductive systems throughout all stages of life. It involves the ability to have a responsible, satisfying, and safe sex life, as well as the capability to reproduce and the freedom to decide if, when, and how often to do so.</p>

<h5>Why Reproductive Health Matters</h5>
<p>Good reproductive health is essential for:</p>
<ul>
<li>Preventing and managing reproductive health conditions</li>
<li>Making informed decisions about family planning</li>
<li>Ensuring safe pregnancy and childbirth</li>
<li>Maintaining sexual health and well-being</li>
<li>Building strong, healthy families and communities</li>
</ul>

<h5>How We Can Help</h5>
<p>At UzaziClinic, we offer comprehensive reproductive health services including family planning counseling, maternal health consultations, pregnancy testing, and reproductive health education. Our team of specialists is dedicated to providing confidential, compassionate care in a supportive environment.</p>

<p>Whether you are planning a family, managing a reproductive health concern, or simply seeking information, we are here to support you every step of the way.</p>",
                'image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=1200&q=60',
                'author' => 'Dr. Issa Rashid',
                'tags' => 'reproductive health,women health,family planning,education',
                'read_time' => '6 min read',
                'status' => 'published',
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Choosing the Right Contraceptive: Options and Guidance',
                'slug' => 'choosing-right-contraceptive-options',
                'category' => 'Family Planning',
                'excerpt' => 'A comprehensive overview of contraceptive methods available at UzaziClinic to help you make an informed choice that suits your lifestyle and health needs.',
                'content' => "<p>Choosing a contraceptive method is a personal decision that depends on your health, lifestyle, and family planning goals. At UzaziClinic, we provide expert counseling to help you understand your options and select the method that is right for you.</p>

<h5>Types of Contraceptive Methods</h5>
<p>There are many effective contraceptive options available, including:</p>
<ul>
<li><strong>Hormonal Methods:</strong> Birth control pills, patches, injections, and implants that regulate hormones to prevent pregnancy</li>
<li><strong>Intrauterine Devices (IUDs):</strong> Small, T-shaped devices inserted into the uterus that provide long-term pregnancy protection</li>
<li><strong>Barrier Methods:</strong> Condoms, diaphragms, and cervical caps that physically block sperm from reaching the egg</li>
<li><strong>Natural Methods:</strong> Fertility awareness and tracking your menstrual cycle to identify fertile days</li>
<li><strong>Emergency Contraception:</strong> Options available after unprotected sex to prevent pregnancy</li>
<li><strong>Permanent Methods:</strong> Sterilization procedures for those who have completed their family size</li>
</ul>

<h5>How to Choose</h5>
<p>Our family planning counselors will discuss your medical history, lifestyle, and preferences to help you choose the most suitable method. We consider factors such as effectiveness, side effects, convenience, and your future family plans.</p>

<p>Visit UzaziClinic for a confidential family planning counseling session. Our team is here to support you with accurate information and compassionate care.</p>",
                'image' => 'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=60',
                'author' => 'UzaziClinic Team',
                'tags' => 'contraception,family planning,birth control,women health',
                'read_time' => '8 min read',
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Preparing for Pregnancy: Preconception Health Tips',
                'slug' => 'preparing-pregnancy-preconception-health-tips',
                'category' => 'Maternal Health',
                'excerpt' => 'Start your pregnancy journey on the right foot with these essential preconception health tips from our maternal health specialists.',
                'content' => "<p>Planning for a pregnancy is an exciting time. Taking steps to prepare your body before conception can improve your chances of a healthy pregnancy and baby. Here are essential preconception health tips from our team at UzaziClinic.</p>

<h5>Schedule a Preconception Check-up</h5>
<p>Visit UzaziClinic for a preconception health assessment. Our maternal health specialists will review your medical history, discuss any existing health conditions, and provide personalized recommendations.</p>

<h5>Start Taking Folic Acid</h5>
<p>Folic acid is crucial for preventing neural tube defects in early pregnancy. Start taking a daily supplement of 400-800 micrograms at least one month before conception.</p>

<h5>Adopt a Healthy Lifestyle</h5>
<ul>
<li>Eat a balanced diet rich in fruits, vegetables, whole grains, and lean proteins</li>
<li>Maintain a healthy weight through regular physical activity</li>
<li>Avoid alcohol, tobacco, and recreational drugs</li>
<li>Reduce caffeine intake</li>
<li>Manage stress through relaxation techniques and adequate sleep</li>
</ul>

<h5>Review Your Medications</h5>
<p>Some medications can affect fertility or harm a developing fetus. Bring all your medications (including over-the-counter and herbal supplements) to your preconception visit for review.</p>

<p>Ready to start your pregnancy journey? Book a preconception consultation at UzaziClinic today.</p>",
                'image' => 'https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?auto=format&fit=crop&w=1200&q=60',
                'author' => 'Dr. Maria Mwangi',
                'tags' => 'pregnancy,preconception,maternal health,fertility',
                'read_time' => '5 min read',
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Understanding Prenatal Care: What to Expect',
                'slug' => 'understanding-prenatal-care-what-to-expect',
                'category' => 'Prenatal Care',
                'excerpt' => 'Everything you need to know about prenatal care visits, screenings, and how we support you throughout your pregnancy journey.',
                'content' => "<p>Prenatal care is the healthcare you receive during pregnancy. Regular prenatal visits help ensure the health of both you and your baby. At UzaziClinic, we provide comprehensive prenatal care in a supportive, confidential environment.</p>

<h5>When to Start Prenatal Care</h5>
<p>As soon as you suspect you are pregnant, schedule your first prenatal visit. Early and regular prenatal care is essential for monitoring your health and your baby's development.</p>

<h5>What to Expect at Prenatal Visits</h5>
<ul>
<li><strong>First Visit (8-12 weeks):</strong> Comprehensive health assessment, blood tests, ultrasound dating scan, and discussion of pregnancy care plan</li>
<li><strong>Follow-up Visits (every 4 weeks until 28 weeks):</strong> Blood pressure monitoring, weight check, urine testing, and fetal heartbeat monitoring</li>
<li><strong>Third Trimester (every 2 weeks from 28-36 weeks):</strong> Growth monitoring, position checks, and birth planning discussions</li>
<li><strong>Weekly Visits (36 weeks to delivery):</strong> Close monitoring and preparation for labor and delivery</li>
</ul>

<h5>Why Choose UzaziClinic for Prenatal Care</h5>
<p>Our team provides personalized, compassionate care throughout your pregnancy. We take time to answer your questions, address your concerns, and ensure you feel supported every step of the way. All services are confidential and respectful of your privacy.</p>

<p>Book your prenatal care appointment at UzaziClinic today and let us support you on this beautiful journey.</p>",
                'image' => 'https://images.unsplash.com/photo-1559758711-5d29c5f7a1e3?auto=format&fit=crop&w=1200&q=60',
                'author' => 'UzaziClinic Team',
                'tags' => 'prenatal care,pregnancy,maternal health,baby',
                'read_time' => '7 min read',
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Breaking the Stigma: Talking About Reproductive Health',
                'slug' => 'breaking-stigma-talking-reproductive-health',
                'category' => 'Health Education',
                'excerpt' => 'Open conversations about reproductive health are essential for well-being. Learn why breaking the silence matters and how we create a safe space for you.',
                'content' => "<p>For many people, talking about reproductive health can feel uncomfortable or even taboo. Yet open, honest conversations about reproductive health are essential for individual and community well-being. At UzaziClinic, we are committed to breaking the stigma.</p>

<h5>Why the Stigma Exists</h5>
<p>Cultural norms, lack of comprehensive education, and misinformation contribute to the silence surrounding reproductive health. Many people feel embarrassed or fear judgment when discussing topics like contraception, fertility, or sexual health.</p>

<h5>Why It Matters to Talk</h5>
<ul>
<li>Access to accurate information empowers informed decision-making</li>
<li>Early detection and treatment of reproductive health issues</li>
<li>Reduced rates of unintended pregnancies and STIs</li>
<li>Improved mental health and relationship satisfaction</li>
<li>Stronger, healthier communities</li>
</ul>

<h5>Our Safe Space Promise</h5>
<p>At UzaziClinic, we have created an environment where you can speak openly without fear of judgment. Our team is trained to listen with empathy and respect, maintaining complete confidentiality at all times. No question is too small, and no concern is unimportant.</p>

<p>Whether you need information, counseling, or medical care, we are here for you. Take the first step — schedule a confidential consultation today.</p>",
                'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1200&q=60',
                'author' => 'Sarah Mwamba, Counselor',
                'tags' => 'reproductive health,education,stigma,counseling',
                'read_time' => '5 min read',
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Postpartum Care: Supporting New Mothers',
                'slug' => 'postpartum-care-supporting-new-mothers',
                'category' => 'Maternal Health',
                'excerpt' => 'Essential postpartum care information for new mothers, including physical recovery, emotional well-being, and when to seek support.',
                'content' => "<p>The postpartum period — the first six weeks after childbirth — is a critical time for both mother and baby. At UzaziClinic, we provide comprehensive postpartum support to help new mothers navigate this transformative period with confidence.</p>

<h5>Physical Recovery After Childbirth</h5>
<p>Your body goes through significant changes during pregnancy and childbirth. Postpartum recovery includes:</p>
<ul>
<li>Uterine healing and discharge (lochia)</li>
<li>Perineal care for tear or episiotomy recovery</li>
<li>Breast care and breastfeeding support</li>
<li>Managing postpartum pain and discomfort</li>
<li>Gradual return to physical activity</li>
</ul>

<h5>Emotional Well-being</h5>
<p>Many new mothers experience a range of emotions after childbirth. While mild mood changes are common, persistent feelings of sadness, anxiety, or overwhelm may indicate postpartum depression. Our counselors are here to provide confidential support.</p>

<h5>When to Visit UzaziClinic</h5>
<p>Schedule your postpartum check-up within 2-6 weeks after delivery. We will assess your recovery, discuss family planning options, and address any concerns you may have. Earlier visits are recommended if you experience fever, heavy bleeding, severe pain, or emotional distress.</p>

<p>You don't have to navigate motherhood alone. UzaziClinic is here to support you every step of the way.</p>",
                'image' => 'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=60',
                'author' => 'Dr. Maria Mwangi',
                'tags' => 'postpartum,maternal health,new mothers,recovery',
                'read_time' => '6 min read',
                'status' => 'published',
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => 'Fertility Awareness: Understanding Your Cycle',
                'slug' => 'fertility-awareness-understanding-your-cycle',
                'category' => 'Health Education',
                'excerpt' => 'Learn about fertility awareness methods, tracking your menstrual cycle, and understanding your body\'s natural rhythms for better reproductive health.',
                'content' => "<p>Fertility awareness is the practice of understanding and tracking your body's natural fertility signs. This knowledge can be used for both achieving and avoiding pregnancy naturally. At UzaziClinic, we offer fertility awareness education as part of our comprehensive reproductive health services.</p>

<h5>What is Fertility Awareness?</h5>
<p>Fertility awareness involves observing and recording your body's natural signs to identify when you are fertile and when you are not. This information helps you understand your menstrual cycle and reproductive health better.</p>

<h5>Key Fertility Signs to Track</h5>
<ul>
<li><strong>Basal Body Temperature (BBT):</strong> Your resting body temperature rises slightly after ovulation</li>
<li><strong>Cervical Mucus:</strong> Changes in consistency and appearance throughout your cycle</li>
<li><strong>Cervical Position:</strong> Changes in firmness and openness</li>
<li><strong>Menstrual Cycle Length:</strong> Tracking the length and regularity of your cycles</li>
</ul>

<h5>Benefits of Fertility Awareness</h5>
<ul>
<li>Understand your body and menstrual health better</li>
<li>Identify potential reproductive health issues early</li>
<li>Plan or prevent pregnancy naturally</li>
<li>Improve communication with your healthcare provider</li>
</ul>

<p>Want to learn more about fertility awareness? Book an educational session at UzaziClinic today.</p>",
                'image' => 'https://images.unsplash.com/photo-1543362906-acfc16c67564?auto=format&fit=crop&w=1200&q=60',
                'author' => 'UzaziClinic Team',
                'tags' => 'fertility awareness,menstrual cycle,reproductive health,education',
                'read_time' => '7 min read',
                'status' => 'published',
                'published_at' => now()->subDays(18),
            ],
            [
                'title' => 'Confidentiality in Reproductive Health Care: Your Rights',
                'slug' => 'confidentiality-reproductive-health-care-rights',
                'category' => 'Clinic News',
                'excerpt' => 'Understanding your rights to privacy and confidentiality when seeking reproductive health services at UzaziClinic.',
                'content' => "<p>Confidentiality is a cornerstone of quality reproductive health care. At UzaziClinic, we are committed to protecting your privacy and ensuring you feel safe and respected when accessing our services.</p>

<h5>Your Right to Privacy</h5>
<p>Every patient has the right to confidential reproductive health services. This means:</p>
<ul>
<li>Your personal and medical information is protected</li>
<li>Your visits and consultations are private</li>
<li>Your test results are shared only with you and those you authorize</li>
<li>Your decisions about your care are respected</li>
</ul>

<h5>How We Protect Your Information</h5>
<ul>
<li>Secure electronic health records system with access controls</li>
<li>Private consultation rooms for all discussions and examinations</li>
<li>Strict confidentiality policies that all staff must follow</li>
<li>Your information is never shared without your written consent</li>
</ul>

<h5>What This Means for You</h5>
<p>You can speak openly with our healthcare providers about your concerns, ask questions without hesitation, and make decisions about your reproductive health without fear of judgment or breach of privacy. Your trust is our highest priority.</p>

<p>If you have any questions about our confidentiality practices, please speak with our team. We are here to ensure you feel safe, respected, and supported.</p>",
                'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=1200&q=60',
                'author' => 'UzaziClinic Team',
                'tags' => 'confidentiality,privacy,rights,reproductive health',
                'read_time' => '4 min read',
                'status' => 'published',
                'published_at' => now()->subDays(21),
            ],
        ];

        foreach ($posts as $post) {
            Blog::create($post);
            $this->command->info("Blog post created: {$post['title']}");
        }

        $this->command->info('Blog posts seeded successfully!');
    }
}
