import 'package:flutter/material.dart';
import '../../widgets/common/custom_app_bar.dart';
import '../../widgets/common/bottom_navigation.dart';

/// About Screen
/// 
/// Screen inayoonyesha maelezo kuhusu kliniki.
/// Inajumuisha:
/// - History ya kliniki
/// - Mission na vision
/// - Team info
/// - Values

class AboutScreen extends StatelessWidget {
  const AboutScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: const CustomAppBar(
        title: 'Kuhusu Sisi',
      ),
      body: SafeArea(
        child: SingleChildScrollView(
          child: Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Logo and Title
                Center(
                  child: Column(
                    children: [
                      Image.asset(
                        'assets/images/logo.png',
                        width: 100,
                        height: 100,
                        errorBuilder: (context, error, stackTrace) {
                          return const Icon(
                            Icons.local_hospital,
                            size: 100,
                            color: Colors.grey,
                          );
                        },
                      ),
                      const SizedBox(height: 16),
                      const Text(
                        'Dr Issa Scientist Clinic',
                        style: TextStyle(
                          fontSize: 24,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      const SizedBox(height: 8),
                      const Text(
                        'Hospital Management System',
                        style: TextStyle(
                          fontSize: 14,
                          color: Colors.grey,
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 32),
                
                // Mission
                _buildSection(
                  'Dhamira Yetu',
                  'Kutoa huduma bora za afya kwa jamii kupitia tiba ya kisasa na wataalamu wenye uzoefu.',
                ),
                
                const SizedBox(height: 24),
                
                // Vision
                _buildSection(
                  'Dira Yetu',
                  'Kuwa kliniki inayoongoza katika kutengeneza afya bora kwa jamii ya Tanzania.',
                ),
                
                const SizedBox(height: 24),
                
                // Values
                _buildSection(
                  'Thamani Zetu',
                  '• Uadilifu\n• Ubora\n• Heshima\n• Ushirikiano\n• Mshikamano',
                ),
                
                const SizedBox(height: 24),
                
                // History
                _buildSection(
                  'Historia',
                  'Dr Issa Scientist Clinic ilianzishwa mwaka 2020 na daktari Issa Scientist kwa lengo la kutoa huduma za afya za hali ya juu kwa jamii. Tumekuwa tukihudumia wagonjwa kwa uaminifu na ujuzi.',
                ),
                
                const SizedBox(height: 80),
              ],
            ),
          ),
        ),
      ),
      bottomNavigationBar: const BottomNavigation(),
    );
  }
  
  Widget _buildSection(String title, String content) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              title,
              style: const TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 12),
            Text(
              content,
              style: const TextStyle(
                fontSize: 14,
                color: Colors.grey,
                height: 1.5,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
