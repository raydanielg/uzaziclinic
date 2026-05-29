import 'package:flutter/material.dart';
import '../../widgets/common/custom_app_bar.dart';
import '../../widgets/common/bottom_navigation.dart';

/// Appointments Screen
/// 
/// Screen inayoonyesha miadi za mgonjwa.
/// Inajumuisha:
/// - List ya miadi
/// - Book appointment button
/// - Filter by status
/// - Appointment details

class AppointmentsScreen extends StatelessWidget {
  const AppointmentsScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: const CustomAppBar(
        title: 'Miadi Zangu',
      ),
      body: SafeArea(
        child: Column(
          children: [
            // Filter Tabs
            _buildFilterTabs(context),
            
            // Appointments List
            Expanded(
              child: _buildAppointmentsList(context),
            ),
          ],
        ),
      ),
      floatingActionButton: FloatingActionButton.extended(
        onPressed: () {
          // TODO: Navigate to book appointment
        },
        icon: const Icon(Icons.add),
        label: const Text('Book Miadi'),
      ),
      bottomNavigationBar: const BottomNavigation(),
    );
  }
  
  Widget _buildFilterTabs(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 12),
      child: SingleChildScrollView(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal: 16),
        child: Row(
          children: [
            _buildFilterChip(context, 'Zote', true),
            const SizedBox(width: 8),
            _buildFilterChip(context, 'Inasubiri', false),
            const SizedBox(width: 8),
            _buildFilterChip(context, 'Imethibitishwa', false),
            const SizedBox(width: 8),
            _buildFilterChip(context, 'Imekamilika', false),
            const SizedBox(width: 8),
            _buildFilterChip(context, 'Imefutwa', false),
          ],
        ),
      ),
    );
  }
  
  Widget _buildFilterChip(BuildContext context, String label, bool isSelected) {
    return FilterChip(
      label: Text(label),
      selected: isSelected,
      onSelected: (selected) {
        // TODO: Filter appointments
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
  
  Widget _buildAppointmentsList(BuildContext context) {
    return ListView.builder(
      padding: const EdgeInsets.all(16),
      itemCount: 5,
      itemBuilder: (context, index) {
        return _buildAppointmentCard(context, index);
      },
    );
  }
  
  Widget _buildAppointmentCard(BuildContext context, int index) {
    return Card(
      margin: const EdgeInsets.only(bottom: 16),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  'Miadi #${index + 1}',
                  style: const TextStyle(
                    fontWeight: FontWeight.bold,
                  ),
                ),
                Container(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 8,
                    vertical: 4,
                  ),
                  decoration: BoxDecoration(
                    color: _getStatusColor(index),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Text(
                    _getStatusLabel(index),
                    style: const TextStyle(
                      fontSize: 12,
                      color: Colors.white,
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            _buildInfoRow(Icons.calendar_today, '24 Mei 2026'),
            const SizedBox(height: 8),
            _buildInfoRow(Icons.access_time, '10:00 AM'),
            const SizedBox(height: 8),
            _buildInfoRow(Icons.person, 'Dkt. John Doe'),
            const SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: () {
                      // TODO: View details
                    },
                    icon: const Icon(Icons.visibility, size: 16),
                    label: const Text('Angalia'),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: () {
                      // TODO: Cancel appointment
                    },
                    icon: const Icon(Icons.cancel, size: 16),
                    label: const Text('Futa'),
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
      children: [
        Icon(
          icon,
          size: 16,
          color: Colors.grey,
        ),
        const SizedBox(width: 8),
        Text(
          text,
          style: const TextStyle(
            fontSize: 14,
            color: Colors.grey,
          ),
        ),
      ],
    );
  }
  
  String _getStatusLabel(int index) {
    switch (index % 4) {
      case 0:
        return 'Inasubiri';
      case 1:
        return 'Imethibitishwa';
      case 2:
        return 'Imekamilika';
      case 3:
        return 'Imefutwa';
      default:
        return 'Inasubiri';
    }
  }
  
  Color _getStatusColor(int index) {
    switch (index % 4) {
      case 0:
        return Colors.amber;
      case 1:
        return Colors.blue;
      case 2:
        return Colors.green;
      case 3:
        return Colors.red;
      default:
        return Colors.grey;
    }
  }
}
