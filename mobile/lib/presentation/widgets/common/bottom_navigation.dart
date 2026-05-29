import 'package:flutter/material.dart';
import '../../../core/constants/app_constants.dart';
import '../../routing/app_routes.dart';

/// Bottom Navigation Bar
/// 
/// Navigation bar inayotumika katika screens zote.
/// Inajumuisha:
/// - Home
/// - Appointments
/// - Shop
/// - Blog
/// - Contact

class BottomNavigation extends StatelessWidget {
  const BottomNavigation({super.key});

  @override
  Widget build(BuildContext context) {
    return BottomNavigationBar(
      type: BottomNavigationBarType.fixed,
      currentIndex: _getCurrentIndex(context),
      onTap: (index) {
        _onItemTapped(context, index);
      },
      items: const [
        BottomNavigationBarItem(
          icon: Icon(Icons.home),
          label: 'Nyumbani',
        ),
        BottomNavigationBarItem(
          icon: Icon(Icons.calendar_today),
          label: 'Miadi',
        ),
        BottomNavigationBarItem(
          icon: Icon(Icons.shopping_cart),
          label: 'Duka',
        ),
        BottomNavigationBarItem(
          icon: Icon(Icons.article),
          label: 'Blog',
        ),
        BottomNavigationBarItem(
          icon: Icon(Icons.contact_mail),
          label: 'Wasiliana',
        ),
      ],
      selectedItemColor: Theme.of(context).colorScheme.primary,
      unselectedItemColor: Colors.grey,
      selectedFontSize: 12,
      unselectedFontSize: 12,
    );
  }
  
  int _getCurrentIndex(BuildContext context) {
    final route = ModalRoute.of(context)?.settings.name;
    switch (route) {
      case AppConstants.homeRoute:
        return 0;
      case AppConstants.appointmentsRoute:
        return 1;
      case AppConstants.shopRoute:
        return 2;
      case AppConstants.blogRoute:
        return 3;
      case AppConstants.contactRoute:
        return 4;
      default:
        return 0;
    }
  }
  
  void _onItemTapped(BuildContext context, int index) {
    switch (index) {
      case 0:
        AppRoutes.navigateToHome(context);
        break;
      case 1:
        AppRoutes.navigateToAppointments(context);
        break;
      case 2:
        AppRoutes.navigateToShop(context);
        break;
      case 3:
        AppRoutes.navigateToBlog(context);
        break;
      case 4:
        AppRoutes.navigateToContact(context);
        break;
    }
  }
}
