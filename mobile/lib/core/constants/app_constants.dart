/// App Constants
/// 
/// Hii file ina constant zote zinazotumika katika app nzima.
/// Inajumuisha:
/// - App info (jina, version)
/// - API endpoints
/// - Storage keys
/// - Route names
/// - Timeouts na limits

class AppConstants {
  // ──────────────────────────────────────────────────────────
  // APP INFO
  // ──────────────────────────────────────────────────────────
  static const String appName = 'Dr Issa Scientist Clinic';
  static const String appVersion = '1.0.0';
  static const String packageName = 'com.drissascientist.clinic';
  
  // ──────────────────────────────────────────────────────────
  // API CONFIGURATION
  // ──────────────────────────────────────────────────────────
  // Badilisha base URL kulingana na environment yako (dev/staging/prod)
  static const String baseUrl = 'http://10.0.2.2:8000/api'; // For Android Emulator
  // static const String baseUrl = 'http://localhost:8000/api'; // For iOS Simulator
  // static const String baseUrl = 'https://your-domain.com/api'; // For Production
  
  static const int connectTimeout = 30000; // 30 seconds
  static const int receiveTimeout = 30000; // 30 seconds
  static const int sendTimeout = 30000; // 30 seconds
  
  // ──────────────────────────────────────────────────────────
  // API ENDPOINTS
  // ──────────────────────────────────────────────────────────
  // Authentication
  static const String loginEndpoint = '/login';
  static const String registerEndpoint = '/register';
  static const String logoutEndpoint = '/logout';
  static const String forgotPasswordEndpoint = '/forgot-password';
  
  // Appointments
  static const String appointmentsEndpoint = '/appointments';
  static const String bookAppointmentEndpoint = '/appointments/book';
  static const String cancelAppointmentEndpoint = '/appointments';
  
  // Services
  static const String servicesEndpoint = '/services';
  
  // Blog
  static const String blogEndpoint = '/blog';
  static const String blogCategoriesEndpoint = '/blog/categories';
  
  // Shop
  static const String productsEndpoint = '/products';
  static const String categoriesEndpoint = '/categories';
  static const String cartEndpoint = '/cart';
  static const String ordersEndpoint = '/orders';
  
  // Contact
  static const String contactEndpoint = '/contact';
  
  // Branches
  static const String branchesEndpoint = '/branches';
  
  // About
  static const String aboutEndpoint = '/about';
  
  // ──────────────────────────────────────────────────────────
  // STORAGE KEYS (SharedPreferences)
  // ──────────────────────────────────────────────────────────
  static const String tokenKey = 'auth_token';
  static const String userIdKey = 'user_id';
  static const String userNameKey = 'user_name';
  static const String userEmailKey = 'user_email';
  static const String userPhoneKey = 'user_phone';
  static const String isLoggedInKey = 'is_logged_in';
  static const String languageKey = 'app_language';
  static const String themeKey = 'app_theme';
  
  // ──────────────────────────────────────────────────────────
  // ROUTE NAMES
  // ──────────────────────────────────────────────────────────
  static const String splashRoute = '/splash';
  static const String onboardingRoute = '/onboarding';
  static const String loginRoute = '/login';
  static const String registerRoute = '/register';
  static const String forgotPasswordRoute = '/forgot-password';
  static const String homeRoute = '/home';
  static const String aboutRoute = '/about';
  static const String branchesRoute = '/branches';
  static const String appointmentsRoute = '/appointments';
  static const String servicesRoute = '/services';
  static const String blogRoute = '/blog';
  static const String blogDetailRoute = '/blog-detail';
  static const String shopRoute = '/shop';
  static const String productDetailRoute = '/product-detail';
  static const String cartRoute = '/cart';
  static const String checkoutRoute = '/checkout';
  static const String contactRoute = '/contact';
  static const String loginRoute = '/login';
  static const String registerRoute = '/register';
  static const String profileRoute = '/profile';
  static const String appointmentHistoryRoute = '/appointment-history';
  
  // ──────────────────────────────────────────────────────────
  // PAGINATION
  // ──────────────────────────────────────────────────────────
  static const int defaultPageSize = 20;
  static const int maxPageSize = 100;
  
  // ──────────────────────────────────────────────────────────
  // VALIDATION
  // ──────────────────────────────────────────────────────────
  static const int minPasswordLength = 6;
  static const int maxPasswordLength = 20;
  static const int minPhoneLength = 10;
  static const int maxPhoneLength = 15;
  
  // ──────────────────────────────────────────────────────────
  // ASSETS
  // ──────────────────────────────────────────────────────────
  static const String logoPath = 'assets/images/logo.png';
  static const String placeholderImagePath = 'assets/images/placeholder.png';
}
