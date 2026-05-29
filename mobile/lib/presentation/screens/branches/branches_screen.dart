import 'package:flutter/material.dart';
import '../../widgets/common/custom_app_bar.dart';
import '../../widgets/common/bottom_navigation.dart';

/// Branches Screen
/// 
/// Screen inayoonyesha tawi zote za kliniki.
/// Inajumuisha:
/// - List ya matawi
/// - Location info
/// - Contact info kwa kila tawi
/// - Operating hours

class BranchesScreen extends StatelessWidget {
  const BranchesScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: const CustomAppBar(
        title: 'Matawi Yetu',
      ),
      body: SafeArea(
        child: SingleChildScrollView(
          child: Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text(
                  'Tafuta Tawi Karibu Nako',
                  style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 16),
                
                // Branch Cards
                _buildBranchCard(
                  context,
                  name: 'Tawi Kuu - Dar es Salaam',
                  address: 'Sinza Madukani, Dar es Salaam',
                  phone: '+255 123 456 789',
                  hours: 'Jumatatu - Ijumaa: 8:00 - 18:00\nJumamosi: 9:00 - 14:00',
                ),
                
                const SizedBox(height: 16),
                
                _buildBranchCard(
                  context,
                  name: 'Tawi - Mwanza',
                  address: 'Kapri Point, Mwanza',
                  phone: '+255 123 456 790',
                  hours: 'Jumatatu - Ijumaa: 8:00 - 17:00\nJumamosi: 9:00 - 13:00',
                ),
                
                const SizedBox(height: 16),
                
                _buildBranchCard(
                  context,
                  name: 'Tawi - Arusha',
                  address: 'Njiro Complex, Arusha',
                  phone: '+255 123 456 791',
                  hours: 'Jumatatu - Ijumaa: 8:00 - 17:00\nJumamosi: 9:00 - 13:00',
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
  
  Widget _buildBranchCard(
    BuildContext context, {
    required String name,
    required String address,
    required String phone,
    required String hours,
  }) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                Container(
                  padding: const EdgeInsets.all(12),
                  decoration: BoxDecoration(
                    color: Theme.of(context).colorScheme.primaryContainer,
                    borderRadius: BorderRadius.circular(8),
                  ),
                  child: Icon(
                    Icons.location_on,
                    color: Theme.of(context).colorScheme.primary,
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Text(
                    name,
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 16),
            _buildInfoRow(Icons.location_city, address),
            const SizedBox(height: 8),
            _buildInfoRow(Icons.phone, phone),
            const SizedBox(height: 8),
            _buildInfoRow(Icons.access_time, hours),
            const SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: ElevatedButton.icon(
                    onPressed: () {
                      // TODO: Call phone
                    },
                    icon: const Icon(Icons.call),
                    label: const Text('Piga Simu'),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: () {
                      // TODO: Open map
                    },
                    icon: const Icon(Icons.map),
                    label: const Text('Ramani'),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
  
  Widget _buildInfoRow(IconData icon, String text) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Icon(
          icon,
          size: 18,
          color: Colors.grey,
        ),
        const SizedBox(width: 8),
        Expanded(
          child: Text(
            text,
            style: const TextStyle(
              fontSize: 14,
              color: Colors.grey,
            ),
          ),
        ),
      ],
    );
  }
}
