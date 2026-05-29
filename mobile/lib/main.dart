import 'package:flutter/material.dart';
import 'core/theme/app_theme.dart';
import 'core/constants/app_constants.dart';
import 'presentation/routing/app_routes.dart';
import 'presentation/screens/home/home_screen.dart';

void main() {
  runApp(const DrissaClinicApp());
}

class DrissaClinicApp extends StatelessWidget {
  const DrissaClinicApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: AppConstants.appName,
      debugShowCheckedModeBanner: false,
      theme: AppTheme.lightTheme,
      darkTheme: AppTheme.darkTheme,
      themeMode: ThemeMode.system,
      
      // Initial Route
      initialRoute: AppConstants.splashRoute,
      
      // Route Generator
      onGenerateRoute: AppRoutes.generateRoute,
      
      // Home Screen (fallback)
      home: const HomeScreen(),
    );
  }
}
