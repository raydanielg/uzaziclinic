import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../../../core/constants/app_constants.dart';
import '../../routing/app_routes.dart';

/// Splash Screen
/// 
/// Screen inayoonyesha logo wakati app inapakia.
/// Inajumuisha:
/// - Logo na jina la app
/// - Check kama onboarding imeshakamilika
/// - Navigation kwa onboarding au home

class SplashScreen extends StatefulWidget {
  const SplashScreen({super.key});

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  @override
  void initState() {
    super.initState();
    _checkOnboardingStatus();
  }

  Future<void> _checkOnboardingStatus() async {
    await Future.delayed(const Duration(seconds: 2)); // Show splash for 2 seconds
    
    final prefs = await SharedPreferences.getInstance();
    final onboardingCompleted = prefs.getBool('onboarding_completed') ?? false;
    final isLoggedIn = prefs.getBool(AppConstants.isLoggedInKey) ?? false;
    
    if (mounted) {
      if (!onboardingCompleted) {
        Navigator.pushReplacementNamed(context, AppConstants.onboardingRoute);
      } else if (isLoggedIn) {
        Navigator.pushReplacementNamed(context, AppConstants.homeRoute);
      } else {
        Navigator.pushReplacementNamed(context, AppConstants.loginRoute);
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [
              Colors.green,
              Colors.green.shade300,
            ],
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
          ),
        ),
        child: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              // Logo
              Image.asset(
                'assets/images/logo.png',
                width: 120,
                height: 120,
                errorBuilder: (context, error, stackTrace) {
                  return const Icon(
                    Icons.local_hospital,
                    size: 120,
                    color: Colors.white,
                  );
                },
              ),
              const SizedBox(height: 32),
              
              // App Name
              const Text(
                'Dr Issa Scientist Clinic',
                style: TextStyle(
                  fontSize: 24,
                  fontWeight: FontWeight.bold,
                  color: Colors.white,
                ),
                textAlign: TextAlign.center,
              ),
              const SizedBox(height: 8),
              
              // Tagline
              const Text(
                'Hospital Management System',
                style: TextStyle(
                  fontSize: 14,
                  color: Colors.white70,
                ),
              ),
              const SizedBox(height: 48),
              
              // Loading Indicator
              const CircularProgressIndicator(
                color: Colors.white,
              ),
            ],
          ),
        ),
      ),
    );
  }
}
