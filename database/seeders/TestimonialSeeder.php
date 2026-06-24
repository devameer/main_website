<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        if (Testimonial::exists()) {
            return;
        }

        $rows = [
            ['initials' => 'J.A.',
             'body_en' => 'Ameer has a rare ability to combine design thinking with precise technical execution.',
             'body_ar' => 'يمتلك عامر قدرة نادرة على الجمع بين التفكير التصميمي والتنفيذ التقني الدقيق.'],
            ['initials' => 'C.P.',
             'body_en' => 'Working with him was clear and structured, and the result exceeded our expectations.',
             'body_ar' => 'التعاون معه واضح ومنظم، وكانت النتيجة أسرع وأفضل مما توقعنا.'],
            ['initials' => 'A.K.',
             'body_en' => 'His attention to detail and user experience shows in every product decision.',
             'body_ar' => 'اهتمامه بالتفاصيل وتجربة المستخدم يظهر في كل قرار داخل المنتج.'],
            ['initials' => 'M.D.',
             'body_en' => 'He knows how to turn a complex problem into a simple, understandable interface.',
             'body_ar' => 'يعرف كيف يحوّل المشكلة المعقدة إلى واجهة بسيطة وسهلة الفهم.'],
            ['initials' => 'R.B.',
             'body_en' => 'Clean code, practical feedback, and consistently thoughtful delivery.',
             'body_ar' => 'كوده نظيف، ملاحظاته عملية، والتسليم دائماً مدروس.'],
            ['initials' => 'S.G.',
             'body_en' => 'Ameer listens carefully and balances user needs with business goals.',
             'body_ar' => 'عامر مستمع جيد ويوازن بذكاء بين احتياجات المستخدم وأهداف العمل.'],
            ['initials' => 'T.B.',
             'body_en' => 'A reliable partner who brings real value to the team, not just execution.',
             'body_ar' => 'شريك موثوق يضيف قيمة حقيقية للفريق وليس مجرد منفّذ.'],
            ['initials' => 'V.F.',
             'body_en' => 'I recommend him to any team that values quality, clarity, and craft.',
             'body_ar' => 'أوصي به لأي فريق يبحث عن الجودة والوضوح والاهتمام بالتفاصيل.'],
        ];

        foreach ($rows as $i => $row) {
            Testimonial::create([
                'sort_order'  => $i + 1,
                'initials'    => $row['initials'],
                'author_en'   => $row['initials'],
                'author_ar'   => $row['initials'],
                'role_en'     => 'Product collaborator',
                'role_ar'     => 'متعاون',
                'body_en'     => $row['body_en'],
                'body_ar'     => $row['body_ar'],
                'is_published' => true,
            ]);
        }
    }
}
