<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ---- Accounts ----
        // Passwords are hashed by the User model's setPasswordAttribute().
        User::create(array(
            'name'     => 'Store Admin',
            'email'    => 'admin@ananya.com',
            'password' => 'admin123',
            'role'     => 'admin',
        ));

        User::create(array(
            'name'     => 'Priya Sharma',
            'email'    => 'customer@ananya.com',
            'password' => 'customer123',
            'role'     => 'customer',
            'phone'    => '+94 77 123 4567',
            'address'  => '12, Galle Road',
            'city'     => 'Colombo',
            'state'    => 'Western',
            'zip'      => '00300',
            'country'  => 'Sri Lanka',
        ));

        // ---- Categories (matches the Ananya storefront) ----
        $categories = array(
            array('name' => 'Kitchen Appliances', 'description' => 'Mixers, grinders & modern kitchen machines'),
            array('name' => 'Brass Statues', 'description' => 'Handcrafted brass idols & figurines'),
            array('name' => 'Temple Items', 'description' => 'Diyas, lamps & pooja essentials'),
            array('name' => 'Hotel Kitchen', 'description' => 'Commercial-grade kitchen equipment'),
            array('name' => 'Sowbhagya Brand', 'description' => 'Genuine Sowbhagya appliances'),
            array('name' => 'Cookware & Utensils', 'description' => 'Everyday cookware & serving ware'),
        );

        $sort = 0;
        foreach ($categories as $cat) {
            Category::create(array(
                'name'        => $cat['name'],
                'slug'        => Str::slug($cat['name']),
                'description' => $cat['description'],
                'is_active'   => true,
                'sort_order'  => $sort++,
            ));
        }

        // ---- Products ----
        $products = array(
            array('category' => 'Kitchen Appliances', 'name' => 'Sowbhagya Table Top Wet Grinder 2L', 'price' => 8990, 'sale_price' => 6990, 'stock' => 24, 'description' => 'Powerful 150W table-top wet grinder with conical stones for perfectly smooth batter. Ideal for idli & dosa lovers.', 'is_featured' => true),
            array('category' => 'Kitchen Appliances', 'name' => 'Sowbhagya Mixer Grinder 750W (3 Jars)', 'price' => 5490, 'sale_price' => 4290, 'stock' => 40, 'description' => '750W copper motor mixer grinder with three stainless-steel jars. Handles wet, dry and chutney grinding with ease.', 'is_featured' => true),
            array('category' => 'Brass Statues', 'name' => 'Brass Standing Ganesha Idol 9"', 'price' => 3499, 'stock' => 15, 'description' => 'Hand-finished antique brass Ganesha idol, 9 inches tall. A serene centerpiece for your home mandir or living room.', 'is_featured' => true),
            array('category' => 'Brass Statues', 'name' => 'Brass Nataraja Statue 12"', 'price' => 6799, 'sale_price' => 5999, 'stock' => 8, 'description' => 'Intricately detailed brass Nataraja depicting Lord Shiva\'s cosmic dance. Museum-grade casting and hand polish.'),
            array('category' => 'Brass Statues', 'name' => 'Brass Lakshmi-Ganesha Pair', 'price' => 4299, 'stock' => 20, 'description' => 'Auspicious pair of Lakshmi & Ganesha in solid brass, perfect for Diwali gifting and daily worship.'),
            array('category' => 'Temple Items', 'name' => 'Traditional Brass Deepam / Diya (Set of 2)', 'price' => 1299, 'sale_price' => 999, 'stock' => 60, 'description' => 'Classic South-Indian brass oil lamps. Beautifully turned stems with a warm, lasting shine.', 'is_featured' => true),
            array('category' => 'Temple Items', 'name' => 'Kuthu Vilakku Brass Temple Lamp 15"', 'price' => 4999, 'sale_price' => 3999, 'stock' => 12, 'description' => 'Tall standing temple lamp (kuthu vilakku) in heavy brass, 15 inches. Radiates divine ambience during pooja.', 'is_featured' => true),
            array('category' => 'Temple Items', 'name' => 'Brass Pooja Thali Set (7 Pieces)', 'price' => 2199, 'stock' => 33, 'description' => 'Complete brass pooja thali with kumkum holder, bell, diya, spoon and accessories for daily rituals.'),
            array('category' => 'Hotel Kitchen', 'name' => 'Commercial Idli Steamer 48 Plates', 'price' => 12999, 'sale_price' => 10999, 'stock' => 6, 'description' => 'Stainless-steel commercial idli steamer, 48-plate capacity. Built for busy hotel & tiffin kitchens.'),
            array('category' => 'Hotel Kitchen', 'name' => 'Heavy-Duty 3-Burner Gas Range', 'price' => 24999, 'sale_price' => 21999, 'stock' => 4, 'description' => 'Robust three-burner commercial gas range with high-thermal-efficiency burners and a stainless frame.', 'is_featured' => true),
            array('category' => 'Hotel Kitchen', 'name' => 'Sowbhagya Tilting Wet Grinder 10L', 'price' => 18490, 'sale_price' => 15990, 'stock' => 5, 'description' => 'Commercial 10-litre tilting wet grinder for restaurants and catering. Effortless batter in bulk.'),
            array('category' => 'Sowbhagya Brand', 'name' => 'Sowbhagya Instant Rice Cooker 1.8L', 'price' => 2799, 'sale_price' => 2199, 'stock' => 50, 'description' => 'Reliable 1.8L automatic rice cooker with keep-warm mode and durable non-stick bowl.', 'is_featured' => true),
            array('category' => 'Sowbhagya Brand', 'name' => 'Sowbhagya Induction Cooktop 2000W', 'price' => 3299, 'sale_price' => 2599, 'stock' => 28, 'description' => 'Energy-efficient 2000W induction cooktop with preset menus and push-button controls.'),
            array('category' => 'Sowbhagya Brand', 'name' => 'Sowbhagya Juicer Mixer Grinder', 'price' => 6290, 'stock' => 18, 'description' => 'Versatile juicer + mixer grinder combo with a powerful motor and multiple jars for every prep task.'),
            array('category' => 'Cookware & Utensils', 'name' => 'Stainless Steel Cookware Set (5 Pcs)', 'price' => 3999, 'sale_price' => 3199, 'stock' => 22, 'description' => 'Tri-ply stainless cookware set — kadai, sauce pans and lids with cool-touch handles.', 'is_featured' => true),
            array('category' => 'Cookware & Utensils', 'name' => 'Brass Serving Bowl / Handi (Medium)', 'price' => 1599, 'stock' => 30, 'description' => 'Traditional brass serving handi with tin lining, ideal for authentic serving and gifting.'),
            array('category' => 'Cookware & Utensils', 'name' => 'Non-Stick Dosa Tawa 30cm', 'price' => 1199, 'sale_price' => 899, 'stock' => 45, 'description' => 'Wide 30cm non-stick dosa tawa with even heat distribution for crisp, restaurant-style dosas.'),
            array('category' => 'Temple Items', 'name' => 'Brass Wall-Hanging Bell (Ghanti)', 'price' => 899, 'stock' => 38, 'description' => 'Melodious solid-brass temple bell with ornate detailing for your pooja room entrance.'),
        );

        foreach ($products as $p) {
            $category = Category::where('name', $p['category'])->first();

            $salePrice  = array_key_exists('sale_price', $p) ? $p['sale_price'] : null;
            $isFeatured = array_key_exists('is_featured', $p) ? $p['is_featured'] : false;

            Product::create(array(
                'category_id'       => $category->id,
                'name'              => $p['name'],
                'slug'              => Str::slug($p['name']),
                'description'       => $p['description'],
                'short_description' => Str::limit($p['description'], 80),
                'price'             => $p['price'],
                'sale_price'        => $salePrice,
                'stock'             => $p['stock'],
                'sku'               => strtoupper(Str::random(8)),
                'is_active'         => true,
                'is_featured'       => $isFeatured,
            ));
        }
    }
}
