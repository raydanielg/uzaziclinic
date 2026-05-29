import 'package:flutter/material.dart';
import '../../widgets/common/custom_app_bar.dart';
import '../../widgets/common/bottom_navigation.dart';

/// Services Screen
/// 
/// Screen inayoonyesha huduma zote za kliniki.
/// Inajumuisha:
/// - List ya huduma
/// - Filter by category
/// - Service details na price
/// - Book service button

class ServicesScreen extends StatelessWidget {
  const ServicesScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: const CustomAppBar(
        title: 'Huduma Zetu',
      ),
      body: SafeArea(
        child: Column(
          children: [
            // Search Bar
            _buildSearchBar(context),
            
            // Category Filter
            _buildCategoryFilter(context),
            
            // Services List
            Expanded(
              child: _buildServicesList(context),
            ),
          ],
        ),
      ),
      bottomNavigationBar: const BottomNavigation(),
    );
  }
  
  Widget _buildSearchBar(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(16),
      child: TextField(
        decoration: InputDecoration(
          hintText: 'Tafuta huduma...',
          prefixIcon: const Icon(Icons.search),
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(8),
          ),
        ),
      ),
    );
  }
  
  Widget _buildCategoryFilter(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 12),
      child: SingleChildScrollView(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal: 16),
        child: Row(
          children: [
            _buildCategoryChip(context, 'Zote', true),
            const SizedBox(width: 8),
            _buildCategoryChip(context, 'General', false),
            const SizedBox(width: 8),
            _buildCategoryChip(context, 'Laboratory', false),
            const SizedBox(width: 8),
            _buildCategoryChip(context, 'Radiology', false),
            const SizedBox(width: 8),
            _buildCategoryChip(context, 'Pharmacy', false),
          ],
        ),
      ),
    );
  }
  
  Widget _buildCategoryChip(BuildContext context, String label, bool isSelected) {
    return FilterChip(
      label: Text(label),
      selected: isSelected,
      onSelected: (selected) {
        // TODO: Filter services
      },
      backgroundColor: Colors.grey[200],
      selectedColor: Theme.of(context).colorScheme.primaryContainer,
      labelStyle: TextStyle(
        color: isSelected 
            ? Theme.of(context).colorScheme.primary 
            : Colors.grey[700],
      ),
    );
  }
  
  Widget _buildServicesList(BuildContext context) {
    return GridView.builder(
      padding: const EdgeInsets.all(16),
      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: 2,
        childAspectRatio: 0.75,
        crossAxisSpacing: 16,
        mainAxisSpacing: 16,
      ),
      itemCount: 6,
      itemBuilder: (context, index) {
        return _buildServiceCard(context, index);
      },
    );
  }
  
  Widget _buildServiceCard(BuildContext context, int index) {
    return Card(
      child: InkWell(
        onTap: () {
          // TODO: Navigate to service details
        },
        borderRadius: BorderRadius.circular(12),
        child: Padding(
          padding: const EdgeInsets.all(12),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Container(
                height: 80,
                decoration: BoxDecoration(
                  color: Theme.of(context).colorScheme.primaryContainer,
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Icon(
                  _getServiceIcon(index),
                  size: 40,
                  color: Colors.white,
                ),
              ),
              const SizedBox(height: 12),
              Text(
                _getServiceName(index),
                style: const TextStyle(
                  fontWeight: FontWeight.w600,
                  fontSize: 14,
                ),
                maxLines: 2,
                overflow: TextOverflow.ellipsis,
              ),
              const SizedBox(height: 4),
              Text(
                _getServicePrice(index),
                style: TextStyle(
                  color: Theme.of(context).colorScheme.primary,
                  fontWeight: FontWeight.bold,
                  fontSize: 12,
                ),
              ),
              const Spacer(),
              const Text(
                '30 min',
                style: TextStyle(
                  fontSize: 11,
                  color: Colors.grey,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
  
  IconData _getServiceIcon(int index) {
    switch (index % 6) {
      case 0:
        return Icons.medical_services;
      case 1:
        return Icons.science;
      case 2:
        return Icons.bloodtype;
      case 3:
        return Icons.healing;
      case 4:
        return Icons.vaccines;
      case 5:
        return Icons.pregnant_woman;
      default:
        return Icons.medical_services;
    }
  }
  
  String _getServiceName(int index) {
    switch (index % 6) {
      case 0:
        'General Checkup';
      case 1:
        'Laboratory Tests';
      case 2:
        'Blood Test';
      case 3:
        'X-Ray';
      case 4:
        'Vaccination';
      case 5:
        'Prenatal Care';
      default:
        return 'General Checkup';
    }
    return _getServiceName(index);
  }
  
  String _getServicePrice(int index) {
    switch (index % 6) {
      case 0:
        return 'Tsh 50,000';
      case 1:
        return 'Tsh 30,000';
      case 2:
        return 'Tsh 25,000';
      case 3:
        return 'Tsh 40,000';
      case 4:
        return 'Tsh 20,000';
      case 5:
        return 'Tsh 35,000';
      default:
        return 'Tsh 50,000';
    }
  }
}
