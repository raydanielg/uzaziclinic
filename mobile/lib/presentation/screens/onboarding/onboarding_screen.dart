import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../../widgets/common/custom_app_bar.dart';
import '../../routing/app_routes.dart';
import '../../../core/constants/app_constants.dart';

/// Onboarding Screen
/// 
/// Screen inayoonyesha onboarding kwa watumiaji wapya.
/// Inajumuisha:
/// - 3 slides za onboarding
/// - Skip button
/// - Next/Previous navigation
/// - Page indicators
/// - Get Started button
/// - Auto-skip after onboarding

class OnboardingScreen extends StatefulWidget {
  const OnboardingScreen({super.key});

  @override
  State<OnboardingScreen> createState() => _OnboardingScreenState();
}

class _OnboardingScreenState extends State<OnboardingScreen> {
  final PageController _pageController = PageController();
  int _currentPage = 0;
  
  final List<OnboardingItem> _onboardingItems = [
    OnboardingItem(
      title: 'Huduma Bora za Afya',
      description: 'Tunatoa huduma bora za afya kwa wote kwa kutumia tiba ya kisasa na wataalamu wenye uzoefu.',
      icon: Icons.local_hospital,
      color: Colors.green,
    ),
    OnboardingItem(
      title: 'Book Miadi Kwa Urahisi',
      description: 'Weka miadi yako kwa urahisi kupitia app yetu. Chagua daktari, siku, na muda unaopenda.',
      icon: Icons.calendar_today,
      color: Colors.blue,
    ),
    OnboardingItem(
      title: 'Duka la Dawa Mtandaoni',
      description: 'Nunua dawa na bidhaa za afya kutoka duka letu mtandaoni na zikufikie mahali ulipo.',
      icon: Icons.shopping_cart,
      color: Colors.purple,
    ),
  ];

  @override
  void dispose() {
    _pageController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Column(
          children: [
            // Skip Button
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.end,
                children: [
                  if (_currentPage < _onboardingItems.length - 1)
                    TextButton(
                      onPressed: _skipOnboarding,
                      child: const Text('Ruka'),
                    ),
                ],
              ),
            ),
            
            // Page View
            Expanded(
              child: PageView.builder(
                controller: _pageController,
                onPageChanged: (index) {
                  setState(() {
                    _currentPage = index;
                  });
                },
                itemCount: _onboardingItems.length,
                itemBuilder: (context, index) {
                  return _buildOnboardingPage(_onboardingItems[index]);
                },
              ),
            ),
            
            // Page Indicators
            Padding(
              padding: const EdgeInsets.symmetric(vertical: 24),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: List.generate(
                  _onboardingItems.length,
                  (index) => _buildPageIndicator(index),
                ),
              ),
            ),
            
            // Navigation Buttons
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
              child: Row(
                children: [
                  if (_currentPage > 0)
                    Expanded(
                      child: OutlinedButton(
                        onPressed: _previousPage,
                        child: const Text('Rudi'),
                      ),
                    ),
                  if (_currentPage > 0) const SizedBox(width: 16),
                  Expanded(
                    child: ElevatedButton(
                      onPressed: _currentPage == _onboardingItems.length - 1
                          ? _completeOnboarding
                          : _nextPage,
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.green,
                        foregroundColor: Colors.white,
                      ),
                      child: Text(
                        _currentPage == _onboardingItems.length - 1
                            ? 'Anza Sasa'
                            : 'Endelea',
                      ),
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24),
          ],
        ),
      ),
    );
  }
  
  Widget _buildOnboardingPage(OnboardingItem item) {
    return Padding(
      padding: const EdgeInsets.all(24),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          // Icon/Illustration
          Container(
            width: 200,
            height: 200,
            decoration: BoxDecoration(
              color: item.color.withOpacity(0.1),
              shape: BoxShape.circle,
            ),
            child: Icon(
              item.icon,
              size: 100,
              color: item.color,
            ),
          ),
          const SizedBox(height: 48),
          
          // Title
          Text(
            item.title,
            style: const TextStyle(
              fontSize: 28,
              fontWeight: FontWeight.bold,
              color: Colors.black87,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 16),
          
          // Description
          Text(
            item.description,
            style: const TextStyle(
              fontSize: 16,
              color: Colors.grey,
              height: 1.5,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }
  
  Widget _buildPageIndicator(int index) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 4),
      width: _currentPage == index ? 24 : 8,
      height: 8,
      decoration: BoxDecoration(
        color: _currentPage == index ? Colors.green : Colors.grey[300],
        borderRadius: BorderRadius.circular(4),
      ),
    );
  }
  
  void _nextPage() {
    if (_currentPage < _onboardingItems.length - 1) {
      _pageController.nextPage(
        duration: const Duration(milliseconds: 300),
        curve: Curves.easeInOut,
      );
    }
  }
  
  void _previousPage() {
    if (_currentPage > 0) {
      _pageController.previousPage(
        duration: const Duration(milliseconds: 300),
        curve: Curves.easeInOut,
      );
    }
  }
  
  void _skipOnboarding() async {
    await _markOnboardingComplete();
    if (mounted) {
      Navigator.pushReplacementNamed(context, AppConstants.loginRoute);
    }
  }
  
  void _completeOnboarding() async {
    await _markOnboardingComplete();
    if (mounted) {
      Navigator.pushReplacementNamed(context, AppConstants.loginRoute);
    }
  }
  
  Future<void> _markOnboardingComplete() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setBool('onboarding_completed', true);
  }
}

class OnboardingItem {
  final String title;
  final String description;
  final IconData icon;
  final Color color;
  
  OnboardingItem({
    required this.title,
    required this.description,
    required this.icon,
    required this.color,
  });
}
