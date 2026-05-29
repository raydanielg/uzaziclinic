import 'package:flutter/material.dart';
import '../../core/constants/app_constants.dart';
import '../screens/splash/splash_screen.dart';
import '../screens/onboarding/onboarding_screen.dart';
import '../screens/auth/login_screen.dart';
import '../screens/auth/register_screen.dart';
import '../screens/auth/forgot_password_screen.dart';
import '../screens/home/home_screen.dart';
import '../screens/about/about_screen.dart';
import '../screens/branches/branches_screen.dart';
import '../screens/appointments/appointments_screen.dart';
import '../screens/services/services_screen.dart';
import '../screens/blog/blog_screen.dart';
import '../screens/shop/shop_screen.dart';
import '../screens/contact/contact_screen.dart';

/// App Routes
/// 
/// Hii file ina route configurations zote za app.
/// Inatumia named routes kwa navigation.
/// Inajumuisha:
/// - Route definitions
/// - Route guards (authentication)
/// - Route parameters

class AppRoutes {
  // ──────────────────────────────────────────────────────────
  // ROUTE GENERATOR
  // ──────────────────────────────────────────────────────────
  static Route<dynamic> generateRoute(RouteSettings settings) {
    switch (settings.name) {
      case AppConstants.splashRoute:
        return MaterialPageRoute(
          builder: (_) => const SplashScreen(),
        );
        
      case AppConstants.onboardingRoute:
        return MaterialPageRoute(
          builder: (_) => const OnboardingScreen(),
        );
        
      case AppConstants.loginRoute:
        return MaterialPageRoute(
          builder: (_) => const LoginScreen(),
        );
        
      case AppConstants.registerRoute:
        return MaterialPageRoute(
          builder: (_) => const RegisterScreen(),
        );
        
      case AppConstants.forgotPasswordRoute:
        return MaterialPageRoute(
          builder: (_) => const ForgotPasswordScreen(),
        );
        
      case AppConstants.homeRoute:
        return MaterialPageRoute(
          builder: (_) => const HomeScreen(),
        );
        
      case AppConstants.aboutRoute:
        return MaterialPageRoute(
          builder: (_) => const AboutScreen(),
        );
        
      case AppConstants.branchesRoute:
        return MaterialPageRoute(
          builder: (_) => const BranchesScreen(),
        );
        
      case AppConstants.appointmentsRoute:
        return MaterialPageRoute(
          builder: (_) => const AppointmentsScreen(),
        );
        
      case AppConstants.servicesRoute:
        return MaterialPageRoute(
          builder: (_) => const ServicesScreen(),
        );
        
      case AppConstants.blogRoute:
        return MaterialPageRoute(
          builder: (_) => const BlogScreen(),
        );
        
      case AppConstants.shopRoute:
        return MaterialPageRoute(
          builder: (_) => const ShopScreen(),
        );
        
      case AppConstants.contactRoute:
        return MaterialPageRoute(
          builder: (_) => const ContactScreen(),
        );
        
      default:
        return MaterialPageRoute(
          builder: (_) => const HomeScreen(),
        );
    }
  }
  
  // ──────────────────────────────────────────────────────────
  // NAVIGATION HELPERS
  // ──────────────────────────────────────────────────────────
  
  /// Navigate to home
  static void navigateToHome(BuildContext context) {
    Navigator.pushNamed(context, AppConstants.homeRoute);
  }
  
  /// Navigate to about
  static void navigateToAbout(BuildContext context) {
    Navigator.pushNamed(context, AppConstants.aboutRoute);
  }
  
  /// Navigate to branches
  static void navigateToBranches(BuildContext context) {
    Navigator.pushNamed(context, AppConstants.branchesRoute);
  }
  
  /// Navigate to appointments
  static void navigateToAppointments(BuildContext context) {
    Navigator.pushNamed(context, AppConstants.appointmentsRoute);
  }
  
  /// Navigate to services
  static void navigateToServices(BuildContext context) {
    Navigator.pushNamed(context, AppConstants.servicesRoute);
  }
  
  /// Navigate to blog
  static void navigateToBlog(BuildContext context) {
    Navigator.pushNamed(context, AppConstants.blogRoute);
  }
  
  /// Navigate to shop
  static void navigateToShop(BuildContext context) {
    Navigator.pushNamed(context, AppConstants.shopRoute);
  }
  
  /// Navigate to contact
  static void navigateToContact(BuildContext context) {
    Navigator.pushNamed(context, AppConstants.contactRoute);
  }
  
  /// Navigate back
  static void navigateBack(BuildContext context) {
    Navigator.pop(context);
  }
}
