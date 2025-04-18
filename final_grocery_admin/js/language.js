document.addEventListener('DOMContentLoaded', function() {
    // Language translations
    const translations = {
        en: {
            // Navigation
            "home": "Home",
            "shop": "Shop",
            "categories": "Categories",
            "deals": "Deals",
            "about_us": "About Us",
            "contact": "Contact",
            
            // Hero Section
            "hero_title": "Fresh Groceries Delivered to Your Door",
            "hero_subtitle": "Shop from our wide selection of fresh produce, pantry essentials, and more.",
            "shop_now": "Shop Now",
            "popular_categories": "Popular Categories",
            
            // Categories
            "browse_categories": "Browse Categories",
            "view_all_categories": "View All Categories",
            "fruits_vegetables": "Fruits & Vegetables",
            "dairy_eggs": "Dairy & Eggs",
            "bakery": "Bakery",
            "meat_seafood": "Meat & Seafood",
            "frozen_foods": "Frozen Foods",
            "pantry": "Pantry",
            "beverages": "Beverages",
            "snacks": "Snacks",
            
            // Featured Products
            "featured_products": "Featured Products",
            "view_all_products": "View All Products",
            "add_to_cart": "Add to Cart",
            "new": "New",
            "sale": "Sale",
            
            // Why Shop With Us
            "why_shop_with_us": "Why Shop With Us",
            "always_fresh": "Always Fresh",
            "fast_delivery": "Fast Delivery",
            "premium_quality": "Premium Quality",
            "support_24_7": "24/7 Support",
            "fresh_source": "We source directly from local farms and suppliers",
            "delivery_hours": "Get your groceries delivered within hours",
            "best_products": "We select only the best products for you",
            "always_available": "Our customer support team is always available",
            
            // Footer
            "quick_links": "Quick Links",
            "faq": "FAQ",
            "terms": "Terms & Conditions",
            "privacy": "Privacy Policy",
            "subscribe": "Subscribe to our newsletter",
            "your_email": "Your email",
            "subscribe_button": "Subscribe",
            
            // Auth Pages
            "login": "Login",
            "login_account": "Login to Your Account",
            "email": "Email",
            "password": "Password",
            "remember_me": "Remember me",
            "forgot_password": "Forgot password?",
            "login_button": "Login",
            "dont_have_account": "Don't have an account?",
            "signup": "Sign up",
            "or": "OR",
            "continue_google": "Continue with Google",
            "continue_facebook": "Continue with Facebook",
            
            "create_account": "Create an Account",
            "first_name": "First Name",
            "last_name": "Last Name",
            "phone": "Phone Number",
            "confirm_password": "Confirm Password",
            "password_strength": "Password strength",
            "agree_terms": "I agree to the Terms of Service and Privacy Policy",
            "create_button": "Create Account",
            "already_account": "Already have an account?",
            
            "verify_email": "Verify Your Email",
            "verify_message": "We've sent a verification code to your email. Please enter the code below to verify your account.",
            "code_expires": "Code expires in:",
            "verify_button": "Verify",
            "didnt_receive": "Didn't receive the code?",
            "resend_code": "Resend Code",
            
            "forgot_password_title": "Forgot Password",
            "forgot_message": "Enter your email address, and we'll send you a link to reset your password.",
            "send_reset": "Send Reset Link",
            "remember_password": "Remember your password?",
            
            // Product Translations
            "product_avocado": "Organic Avocados",
            "product_avocado_price": "₹414.17",
            "product_strawberry": "Fresh Strawberries",
            "product_strawberry_price": "₹289.67",
            "product_strawberry_original": "₹414.17",
            "product_bread": "Artisan Sourdough Bread",
            "product_bread_price": "₹497.17",
            "product_milk": "Organic Milk",
            "product_milk_price": "₹273.07",
            "product_mango": "Fresh Mangoes",
            "product_mango_price": "₹349.99",
            "product_honey": "Pure Honey",
            "product_honey_price": "₹456.50",
            "product_almonds": "Premium Almonds",
            "product_almonds_price": "₹599.99",
            "product_almonds_original": "₹749.99",
            "product_chocolate": "Dark Chocolate",
            "product_chocolate_price": "₹299.99",
            'about': {
                'pageTitle': 'About Us - GlobalGrocers',
                'aboutUs': 'About Us',
                'home': 'Home',
                'trustedPartner': 'Your Trusted Grocery Partner',
                'aboutStory1': 'GlobalGrocers started with a simple mission: to make quality groceries accessible to everyone. Founded in 2020, we\'ve grown from a small local store to a trusted online grocery platform serving thousands of customers.',
                'aboutStory2': 'We work directly with farmers, artisans, and producers to bring you the freshest products at the best prices. Our commitment to quality, sustainability, and customer satisfaction drives everything we do.',
                'happyCustomers': 'Happy Customers',
                'products': 'Products',
                'satisfactionRate': 'Satisfaction Rate',
                'coreValues': 'Our Core Values',
                'qualityFirst': 'Quality First',
                'qualityDesc': 'We ensure only the freshest and highest quality products reach our customers.',
                'fastDelivery': 'Fast Delivery',
                'deliveryDesc': 'Same-day delivery to ensure your groceries arrive fresh and on time.',
                'customerCare': 'Customer Care',
                'customerCareDesc': '24/7 support to assist you with any questions or concerns.',
                'sustainability': 'Sustainability',
                'sustainabilityDesc': 'Committed to eco-friendly practices and sustainable packaging.',
                'meetTeam': 'Meet Our Team'
            }
        },
        es: {
            // Navigation
            "home": "Inicio",
            "shop": "Tienda",
            "categories": "Categorías",
            "deals": "Ofertas",
            "about_us": "Nosotros",
            "contact": "Contacto",
            
            // Hero Section
            "hero_title": "Comestibles Frescos Entregados a Su Puerta",
            "hero_subtitle": "Compre de nuestra amplia selección de productos frescos, artículos de despensa y más.",
            "shop_now": "Comprar Ahora",
            "popular_categories": "Categorías Populares",
            
            // Categories
            "browse_categories": "Explorar Categorías",
            "view_all_categories": "Ver Todas las Categorías",
            "fruits_vegetables": "Frutas y Verduras",
            "dairy_eggs": "Lácteos y Huevos",
            "bakery": "Panadería",
            "meat_seafood": "Carnes y Mariscos",
            "frozen_foods": "Alimentos Congelados",
            "pantry": "Despensa",
            "beverages": "Bebidas",
            "snacks": "Snacks",
            
            // Featured Products
            "featured_products": "Productos Destacados",
            "view_all_products": "Ver Todos los Productos",
            "add_to_cart": "Añadir al Carrito",
            "new": "Nuevo",
            "sale": "Oferta",
            
            // Why Shop With Us
            "why_shop_with_us": "Por Qué Comprar Con Nosotros",
            "always_fresh": "Siempre Fresco",
            "fast_delivery": "Entrega Rápida",
            "premium_quality": "Calidad Premium",
            "support_24_7": "Soporte 24/7",
            "fresh_source": "Obtenemos productos directamente de granjas y proveedores locales",
            "delivery_hours": "Reciba sus comestibles en pocas horas",
            "best_products": "Seleccionamos solo los mejores productos para usted",
            "always_available": "Nuestro equipo de soporte está siempre disponible",
            
            // Footer
            "quick_links": "Enlaces Rápidos",
            "faq": "Preguntas Frecuentes",
            "terms": "Términos y Condiciones",
            "privacy": "Política de Privacidad",
            "subscribe": "Suscríbase a nuestro boletín",
            "your_email": "Su correo electrónico",
            "subscribe_button": "Suscribirse",
            
            // Auth Pages
            "login": "Iniciar Sesión",
            "login_account": "Inicie Sesión en Su Cuenta",
            "email": "Correo Electrónico",
            "password": "Contraseña",
            "remember_me": "Recordarme",
            "forgot_password": "¿Olvidó su contraseña?",
            "login_button": "Iniciar Sesión",
            "dont_have_account": "¿No tiene una cuenta?",
            "signup": "Regístrese",
            "or": "O",
            "continue_google": "Continuar con Google",
            "continue_facebook": "Continuar con Facebook",
            
            "create_account": "Crear una Cuenta",
            "first_name": "Nombre",
            "last_name": "Apellido",
            "phone": "Número de Teléfono",
            "confirm_password": "Confirmar Contraseña",
            "password_strength": "Fortaleza de la contraseña",
            "agree_terms": "Acepto los Términos de Servicio y la Política de Privacidad",
            "create_button": "Crear Cuenta",
            "already_account": "¿Ya tiene una cuenta?",
            
            "verify_email": "Verifique Su Correo Electrónico",
            "verify_message": "Hemos enviado un código de verificación a su correo electrónico. Por favor ingrese el código a continuación para verificar su cuenta.",
            "code_expires": "El código expira en:",
            "verify_button": "Verificar",
            "didnt_receive": "¿No recibió el código?",
            "resend_code": "Reenviar Código",
            
            "forgot_password_title": "Olvidó Su Contraseña",
            "forgot_message": "Ingrese su dirección de correo electrónico y le enviaremos un enlace para restablecer su contraseña.",
            "send_reset": "Enviar Enlace de Restablecimiento",
            "remember_password": "¿Recuerda su contraseña?",
            
            // Product Translations
            "product_avocado": "Aguacates Orgánicos",
            "product_avocado_price": "₹414.17",
            "product_strawberry": "Fresas Frescas",
            "product_strawberry_price": "₹289.67",
            "product_strawberry_original": "₹414.17",
            "product_bread": "Pan de Masa Madre Artesanal",
            "product_bread_price": "₹497.17",
            "product_milk": "Leche Orgánica",
            "product_milk_price": "₹273.07",
            "product_mango": "Mangos Frescos",
            "product_mango_price": "₹349.99",
            "product_honey": "Miel Pura",
            "product_honey_price": "₹456.50",
            "product_almonds": "Almendras Premium",
            "product_almonds_price": "₹599.99",
            "product_almonds_original": "₹749.99",
            "product_chocolate": "Chocolate Negro",
            "product_chocolate_price": "₹299.99",
            'about': {
                'pageTitle': 'Sobre Nosotros - GlobalGrocers',
                'aboutUs': 'Sobre Nosotros',
                'home': 'Inicio',
                'trustedPartner': 'Tu Socio de Confianza en Comestibles',
                'aboutStory1': 'GlobalGrocers comenzó con una misión simple: hacer que los comestibles de calidad sean accesibles para todos. Fundada en 2020, hemos crecido de una pequeña tienda local a una plataforma de comestibles en línea de confianza que sirve a miles de clientes.',
                'aboutStory2': 'Trabajamos directamente con agricultores, artesanos y productores para traerte los productos más frescos a los mejores precios. Nuestro compromiso con la calidad, la sostenibilidad y la satisfacción del cliente impulsa todo lo que hacemos.',
                'happyCustomers': 'Clientes Satisfechos',
                'products': 'Productos',
                'satisfactionRate': 'Tasa de Satisfacción',
                'coreValues': 'Nuestros Valores Fundamentales',
                'qualityFirst': 'Calidad Primero',
                'qualityDesc': 'Nos aseguramos de que solo los productos más frescos y de la más alta calidad lleguen a nuestros clientes.',
                'fastDelivery': 'Entrega Rápida',
                'deliveryDesc': 'Entrega el mismo día para asegurar que tus comestibles lleguen frescos y a tiempo.',
                'customerCare': 'Atención al Cliente',
                'customerCareDesc': 'Soporte 24/7 para ayudarte con cualquier pregunta o inquietud.',
                'sustainability': 'Sostenibilidad',
                'sustainabilityDesc': 'Comprometidos con prácticas ecológicas y embalajes sostenibles.',
                'meetTeam': 'Conoce a Nuestro Equipo'
            }
        },
        fr: {
            // Navigation
            "home": "Accueil",
            "shop": "Boutique",
            "categories": "Catégories",
            "deals": "Offres",
            "about_us": "À Propos",
            "contact": "Contact",
            
            // Hero Section
            "hero_title": "Produits Frais Livrés à Votre Porte",
            "hero_subtitle": "Découvrez notre large sélection de produits frais, d'essentiels de garde-manger et plus encore.",
            "shop_now": "Acheter Maintenant",
            "popular_categories": "Catégories Populaires",
            
            // Categories
            "browse_categories": "Parcourir les Catégories",
            "view_all_categories": "Voir Toutes les Catégories",
            "fruits_vegetables": "Fruits et Légumes",
            "dairy_eggs": "Produits Laitiers et Œufs",
            "bakery": "Boulangerie",
            "meat_seafood": "Viandes et Fruits de Mer",
            "frozen_foods": "Surgelés",
            "pantry": "Garde-Manger",
            "beverages": "Boissons",
            "snacks": "Collations",
            
            // Featured Products
            "featured_products": "Produits en Vedette",
            "view_all_products": "Voir Tous les Produits",
            "add_to_cart": "Ajouter au Panier",
            "new": "Nouveau",
            "sale": "Solde",
            
            // Why Shop With Us
            "why_shop_with_us": "Pourquoi Acheter Chez Nous",
            "always_fresh": "Toujours Frais",
            "fast_delivery": "Livraison Rapide",
            "premium_quality": "Qualité Premium",
            "support_24_7": "Support 24/7",
            "fresh_source": "Nous nous approvisionnons directement auprès des fermes et fournisseurs locaux",
            "delivery_hours": "Recevez vos courses en quelques heures",
            "best_products": "Nous sélectionnons uniquement les meilleurs produits pour vous",
            "always_available": "Notre équipe de support client est toujours disponible",
            
            // Footer
            "quick_links": "Liens Rapides",
            "faq": "FAQ",
            "terms": "Conditions Générales",
            "privacy": "Politique de Confidentialité",
            "subscribe": "Abonnez-vous à notre newsletter",
            "your_email": "Votre email",
            "subscribe_button": "S'abonner",
            
            // Auth Pages
            "login": "Connexion",
            "login_account": "Connectez-vous à Votre Compte",
            "email": "Email",
            "password": "Mot de Passe",
            "remember_me": "Se souvenir de moi",
            "forgot_password": "Mot de passe oublié?",
            "login_button": "Se Connecter",
            "dont_have_account": "Vous n'avez pas de compte?",
            "signup": "S'inscrire",
            "or": "OU",
            "continue_google": "Continuer avec Google",
            "continue_facebook": "Continuer avec Facebook",
            
            "create_account": "Créer un Compte",
            "first_name": "Prénom",
            "last_name": "Nom",
            "phone": "Numéro de Téléphone",
            "confirm_password": "Confirmer le Mot de Passe",
            "password_strength": "Force du mot de passe",
            "agree_terms": "J'accepte les Conditions d'Utilisation et la Politique de Confidentialité",
            "create_button": "Créer un Compte",
            "already_account": "Vous avez déjà un compte?",
            
            "verify_email": "Vérifiez Votre Email",
            "verify_message": "Nous avons envoyé un code de vérification à votre email. Veuillez entrer le code ci-dessous pour vérifier votre compte.",
            "code_expires": "Le code expire dans:",
            "verify_button": "Vérifier",
            "didnt_receive": "Vous n'avez pas reçu le code?",
            "resend_code": "Renvoyer le Code",
            
            "forgot_password_title": "Mot de Passe Oublié",
            "forgot_message": "Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.",
            "send_reset": "Envoyer le Lien de Réinitialisation",
            "remember_password": "Vous vous souvenez de votre mot de passe?",
            
            // Product Translations
            "product_avocado": "Avocats Biologiques",
            "product_avocado_price": "₹414.17",
            "product_strawberry": "Fraises Fraîches",
            "product_strawberry_price": "₹289.67",
            "product_strawberry_original": "₹414.17",
            "product_bread": "Pain au Levain Artisanal",
            "product_bread_price": "₹497.17",
            "product_milk": "Lait Biologique",
            "product_milk_price": "₹273.07",
            "product_mango": "Mangues Fraîches",
            "product_mango_price": "₹349.99",
            "product_honey": "Miel Pur",
            "product_honey_price": "₹456.50",
            "product_almonds": "Amandes Premium",
            "product_almonds_price": "₹599.99",
            "product_almonds_original": "₹749.99",
            "product_chocolate": "Chocolat Noir",
            "product_chocolate_price": "₹299.99"
        },
        hi: {
            // Navigation
            "home": "होम",
            "shop": "शॉप",
            "categories": "श्रेणियां",
            "deals": "डील्स",
            "about_us": "हमारे बारे में",
            "contact": "संपर्क",
            
            // Hero Section
            "hero_title": "ताज़ी किराना आपके दरवाजे पर पहुंचाई",
            "hero_subtitle": "हमारे ताज़े उत्पादों, पेंट्री आवश्यकताओं और अधिक के व्यापक चयन से खरीदारी करें।",
            "shop_now": "अभी खरीदें",
            "popular_categories": "लोकप्रिय श्रेणियां",
            
            // Categories
            "browse_categories": "श्रेणियां ब्राउज़ करें",
            "view_all_categories": "सभी श्रेणियां देखें",
            "fruits_vegetables": "फल और सब्जियां",
            "dairy_eggs": "डेयरी और अंडे",
            "bakery": "बेकरी",
            "meat_seafood": "मांस और समुद्री भोजन",
            "frozen_foods": "फ्रोजन फूड्स",
            "pantry": "पेंट्री",
            "beverages": "पेय पदार्थ",
            "snacks": "स्नैक्स",
            
            // Featured Products
            "featured_products": "विशेष उत्पाद",
            "view_all_products": "सभी उत्पाद देखें",
            "add_to_cart": "कार्ट में जोड़ें",
            "new": "नया",
            "sale": "बिक्री",
            
            // Why Shop With Us
            "why_shop_with_us": "हमारे साथ क्यों खरीदारी करें",
            "always_fresh": "हमेशा ताज़ा",
            "fast_delivery": "तेज़ डिलीवरी",
            "premium_quality": "प्रीमियम क्वालिटी",
            "support_24_7": "24/7 सपोर्ट",
            "fresh_source": "हम सीधे स्थानीय खेतों और आपूर्तिकर्ताओं से स्रोत करते हैं",
            "delivery_hours": "कुछ घंटों के भीतर अपनी किराना प्राप्त करें",
            "best_products": "हम आपके लिए केवल सर्वोत्तम उत्पादों का चयन करते हैं",
            "always_available": "हमारी ग्राहक सहायता टीम हमेशा उपलब्ध है",
            
            // Footer
            "quick_links": "त्वरित लिंक",
            "faq": "अक्सर पूछे जाने वाले प्रश्न",
            "terms": "नियम और शर्तें",
            "privacy": "गोपनीयता नीति",
            "subscribe": "हमारे न्यूज़लेटर के लिए सदस्यता लें",
            "your_email": "आपका ईमेल",
            "subscribe_button": "सदस्यता लें",
            
            // Auth Pages
            "login": "लॉगिन",
            "login_account": "अपने खाते में लॉगिन करें",
            "email": "ईमेल",
            "password": "पासवर्ड",
            "remember_me": "मुझे याद रखें",
            "forgot_password": "पासवर्ड भूल गए?",
            "login_button": "लॉगिन",
            "dont_have_account": "खाता नहीं है?",
            "signup": "साइन अप",
            "or": "या",
            "continue_google": "Google के साथ जारी रखें",
            "continue_facebook": "Facebook के साथ जारी रखें",
            
            "create_account": "खाता बनाएं",
            "first_name": "पहला नाम",
            "last_name": "अंतिम नाम",
            "phone": "फोन नंबर",
            "confirm_password": "पासवर्ड की पुष्टि करें",
            "password_strength": "पासवर्ड की मजबूती",
            "agree_terms": "मैं सेवा की शर्तों और गोपनीयता नीति से सहमत हूं",
            "create_button": "खाता बनाएं",
            "already_account": "पहले से ही खाता है?",
            
            "verify_email": "अपना ईमेल सत्यापित करें",
            "verify_message": "हमने आपके ईमेल पर एक सत्यापन कोड भेजा है। कृपया अपने खाते की पुष्टि करने के लिए नीचे कोड दर्ज करें।",
            "code_expires": "कोड समाप्त होता है:",
            "verify_button": "सत्यापित करें",
            "didnt_receive": "कोड नहीं मिला?",
            "resend_code": "कोड पुनः भेजें",
            
            "forgot_password_title": "पासवर्ड भूल गए",
            "forgot_message": "अपना ईमेल पता दर्ज करें, और हम आपको अपना पासवर्ड रीसेट करने के लिए एक लिंक भेजेंगे।",
            "send_reset": "रीसेट लिंक भेजें",
            "remember_password": "अपना पासवर्ड याद है?",
            
            // Product Translations
            "product_avocado": "जैविक एवोकाडो",
            "product_avocado_price": "₹414.17",
            "product_strawberry": "ताजी स्ट्रॉबेरी",
            "product_strawberry_price": "₹289.67",
            "product_strawberry_original": "₹414.17",
            "product_bread": "आर्टिसन साउरडो ब्रेड",
            "product_bread_price": "₹497.17",
            "product_milk": "जैविक दूध",
            "product_milk_price": "₹273.07",
            "product_mango": "ताजा आम",
            "product_mango_price": "₹349.99",
            "product_honey": "शुद्ध शहद",
            "product_honey_price": "₹456.50",
            "product_almonds": "प्रीमियम बादाम",
            "product_almonds_price": "₹599.99",
            "product_almonds_original": "₹749.99",
            "product_chocolate": "डार्क चॉकलेट",
            "product_chocolate_price": "₹299.99"
        },
        sp: {
            // Navigation
            "home": "Inicio",
            "shop": "Tienda",
            "categories": "Categorías",
            "deals": "Ofertas",
            "about_us": "Nosotros",
            "contact": "Contacto",
            
            // Hero Section
            "hero_title": "Comestibles Frescos Entregados a Su Puerta",
            "hero_subtitle": "Compre de nuestra amplia selección de productos frescos, artículos de despensa y más.",
            "shop_now": "Comprar Ahora",
            "popular_categories": "Categorías Populares",
            
            // Categories
            "browse_categories": "Explorar Categorías",
            "view_all_categories": "Ver Todas las Categorías",
            "fruits_vegetables": "Frutas y Verduras",
            "dairy_eggs": "Lácteos y Huevos",
            "bakery": "Panadería",
            "meat_seafood": "Carnes y Mariscos",
            "frozen_foods": "Alimentos Congelados",
            "pantry": "Despensa",
            "beverages": "Bebidas",
            "snacks": "Snacks",
            
            // Featured Products
            "featured_products": "Productos Destacados",
            "view_all_products": "Ver Todos los Productos",
            "add_to_cart": "Añadir al Carrito",
            "new": "Nuevo",
            "sale": "Oferta",
            
            // Why Shop With Us
            "why_shop_with_us": "Por Qué Comprar Con Nosotros",
            "always_fresh": "Siempre Fresco",
            "fast_delivery": "Entrega Rápida",
            "premium_quality": "Calidad Premium",
            "support_24_7": "Soporte 24/7",
            "fresh_source": "Obtenemos productos directamente de granjas y proveedores locales",
            "delivery_hours": "Reciba sus comestibles en pocas horas",
            "best_products": "Seleccionamos solo los mejores productos para usted",
            "always_available": "Nuestro equipo de soporte está siempre disponible",
            
            // Footer
            "quick_links": "Enlaces Rápidos",
            "faq": "Preguntas Frecuentes",
            "terms": "Términos y Condiciones",
            "privacy": "Política de Privacidad",
            "subscribe": "Suscríbase a nuestro boletín",
            "your_email": "Su correo electrónico",
            "subscribe_button": "Suscribirse",
            
            // Auth Pages
            "login": "Iniciar Sesión",
            "login_account": "Inicie Sesión en Su Cuenta",
            "email": "Correo Electrónico",
            "password": "Contraseña",
            "remember_me": "Recordarme",
            "forgot_password": "¿Olvidó su contraseña?",
            "login_button": "Iniciar Sesión",
            "dont_have_account": "¿No tiene una cuenta?",
            "signup": "Regístrese",
            "or": "O",
            "continue_google": "Continuar con Google",
            "continue_facebook": "Continuar con Facebook",
            
            "create_account": "Crear una Cuenta",
            "first_name": "Nombre",
            "last_name": "Apellido",
            "phone": "Número de Teléfono",
            "confirm_password": "Confirmar Contraseña",
            "password_strength": "Fortaleza de la contraseña",
            "agree_terms": "Acepto los Términos de Servicio y la Política de Privacidad",
            "create_button": "Crear Cuenta",
            "already_account": "¿Ya tiene una cuenta?",
            
            "verify_email": "Verifique Su Correo Electrónico",
            "verify_message": "Hemos enviado un código de verificación a su correo electrónico. Por favor ingrese el código a continuación para verificar su cuenta.",
            "code_expires": "El código expira en:",
            "verify_button": "Verificar",
            "didnt_receive": "¿No recibió el código?",
            "resend_code": "Reenviar Código",
            
            "forgot_password_title": "Olvidó Su Contraseña",
            "forgot_message": "Ingrese su dirección de correo electrónico y le enviaremos un enlace para restablecer su contraseña.",
            "send_reset": "Enviar Enlace de Restablecimiento",
            "remember_password": "¿Recuerda su contraseña?",
            
            // Product Translations
            "product_avocado": "Aguacates Orgánicos",
            "product_avocado_price": "₹414.17",
            "product_strawberry": "Fresas Frescas",
            "product_strawberry_price": "₹289.67",
            "product_strawberry_original": "₹414.17",
            "product_bread": "Pan de Masa Madre Artesanal",
            "product_bread_price": "₹497.17",
            "product_milk": "Leche Orgánica",
            "product_milk_price": "₹273.07",
            "product_mango": "Mangos Frescos",
            "product_mango_price": "₹349.99",
            "product_honey": "Miel Pura",
            "product_honey_price": "₹456.50",
            "product_almonds": "Almendras Premium",
            "product_almonds_price": "₹599.99",
            "product_almonds_original": "₹749.99",
            "product_chocolate": "Chocolate Negro",
            "product_chocolate_price": "₹299.99"
        }
    };
    
    // Get current language from localStorage or set default to English
    let currentLanguage = localStorage.getItem('language') || 'en';
    
    // Set language selector value
    const languageSelector = document.querySelector('.language-selector span');
    if (languageSelector) {
        updateLanguageText(currentLanguage);
    }
    
    // Add click event to language options
    const languageOptions = document.querySelectorAll('.language-dropdown a');
    
    languageOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const lang = this.getAttribute('data-lang');
            
            // Save selected language to localStorage
            localStorage.setItem('language', lang);
            currentLanguage = lang;
            
            // Update displayed language
            updateLanguageText(lang);
            
            // Apply translations
            applyTranslations(lang);
        });
    });
    
    // Apply translations on page load
    applyTranslations(currentLanguage);
    
    // Function to update language text in selector
    function updateLanguageText(lang) {
        const languageText = {
            'en': 'English',
            'es': 'Español',
            'fr': 'Français',
            'hi': 'हिंदी',
            'sp': 'Español'
        };
        
        if (languageSelector) {
            languageSelector.innerHTML = `<i class="fas fa-globe"></i> ${languageText[lang]}`;
        }
    }
    
    // Function to apply translations
    function applyTranslations(lang) {
        // Set html lang attribute
        document.documentElement.lang = lang;
        
        // Find all elements with data-lang attribute
        const elementsToTranslate = document.querySelectorAll('[data-lang]');
        
        elementsToTranslate.forEach(element => {
            const key = element.getAttribute('data-lang');
            
            if (translations[lang] && translations[lang][key]) {
                // For input elements, set placeholder if it has one
                if (element.tagName === 'INPUT' && element.hasAttribute('placeholder')) {
                    element.placeholder = translations[lang][key];
                } 
                // For button elements, set text content
                else if (element.tagName === 'BUTTON') {
                    // Check if the button has an icon
                    const icon = element.querySelector('i');
                    if (icon) {
                        // Keep the icon and update the text
                        element.innerHTML = `<i class="${icon.className}"></i> ${translations[lang][key]}`;
                } else {
                        element.textContent = translations[lang][key];
                    }
                }
                // For anchor elements with icons
                else if (element.tagName === 'A' && element.querySelector('i')) {
                    const icon = element.querySelector('i');
                    const iconClass = icon.className;
                    element.innerHTML = `<i class="${iconClass}"></i> ${translations[lang][key]}`;
                }
                // For all other elements
                else {
                    element.textContent = translations[lang][key];
                }
            }
        });

        // Translate product titles and prices
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            const productId = card.getAttribute('data-id');
            if (productId) {
                const titleElement = card.querySelector('.product-title');
                const currentPriceElement = card.querySelector('.current-price');
                const originalPriceElement = card.querySelector('.original-price');

                if (titleElement) {
                    titleElement.textContent = translations[lang][`product_${productId}`];
                }
                if (currentPriceElement) {
                    currentPriceElement.textContent = translations[lang][`product_${productId}_price`];
                }
                if (originalPriceElement) {
                    originalPriceElement.textContent = translations[lang][`product_${productId}_original`];
                }
            }
        });
    }
});