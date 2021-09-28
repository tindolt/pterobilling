import { RootState } from '@/client/redux'
import { GlobalState, setCurrentRouteName } from '@/client/redux/modules/global'
import React from 'react'
import { I18nextProviderProps, withTranslation } from 'react-i18next'
import { connect } from 'react-redux'
import { CombinedState } from 'redux'

const mapStateToProps = (state: RootState): CombinedState<GlobalState> => state.global
const mapDispatchToProps = { setCurrentRouteName }
const sideBarData = [
    Primary: [
    {
        title: 'Dashboard',
        path: '/',
        icon: <i class="fas fa-tachometer-alt"></i>,
        cName: 'nav-text'
    },
    {
        title: 'My Servers',
        path: '/servers',
        icon: <i class="fas fa-server"></i>,
        cName: 'nav-text'
    },
    {
        title: 'Pterodactyl Panel',
        path: '/ppanel',
        icon: <i class="fas fa-columns"></i>,
        cName: 'nav-text'
    },
    {
        title: 'PHPMyAdmin',
        path: '/phppanel',
        icon: <i class="fab fa-php"></i>,
        cName: 'nav-text'
    }
    ],
ActiveServers: [

],
Billing: [

    {
        title: 'Invoices',
        path: '/invoice',
        icon: <i class="fas fa-file-invoice-dollar"></i>,
        cName: 'nav-text'
    }
],
Support: [
    {
        title: 'Support Tickets',
        path: '/tickets',
        icon: <i class="fas fa-ticket-alt"></i>,
        cName: 'nav-text'
    },
    {
        title: 'Knowledge Base',
        path: '/wiki',
        icon: <i class="fas fa-book"></i>,
        cName: 'nav-text'
    },
    {
        title: 'System Status',
        path: '/status',
        icon: <i class="fas fa-ethernet"></i>,
        cName: 'nav-text'
    }
],
Account: [
    {
        title: 'Affiliate Program',
        path: '/affiliate',
        icon: <i class="fas fa-people-arrows"></i>,
        cName: 'nav-text'
    },
    {
        title: 'Account Credit',
        path: '/credit',
        icon: <i class="fas fa-wallet"></i>,
        cName: 'nav-text'
    },
    {
        title: 'Account Settings',
        path: '/settings',
        icon: <i class="fas fa-cogs"></i>,
        cName: 'nav-text'
    }
];

type HomeProps = ReturnType<typeof mapStateToProps> &
  typeof mapDispatchToProps &
  I18nextProviderProps

class Home extends React.Component<HomeProps> {
  public componentDidMount(): void {
    this.props.setCurrentRouteName(this.props.i18n.t('client:routes.home'))
  }

  public render(): JSX.Element {
    return (
      <div>
        <h1>Home</h1>
      </div>
    <aside class="main-sidebar elevation-3">
        <!-- Logo -->
        <a href="#" class="brand-link">
            <img src="/img/icon.webp" alt="Company Name Logo" class="brand-image">
            <span class="brand-text font-weight-light">Your Company Here</span>
        </a>
        <!-- Sidebar Menu -->
        <div class="sidebar">
            <!-- Sidebar Search -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search"/>
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- SideBar Menu -->
            
                <div className='navbar'>
                <Link to='#' className='menu-bars'>
                    <i class="fas fa-bars" onClick={showSidebar}></i>
                </Link>
                </div>
                <nav className={sidebar ? 'nav-menu active' : 'nav-menu'}>
                <ul className='nav-menu-items' onClick={showSidebar}>
                    <li className='navbar-toggle'>
                    <Link to='#' className='menu-bars'>
                        <i class="fas fa-times"></i>
                    </Link>
                    </li>
                    <!-- SideBar navitem population -->
                    sidebarData.forEach(entry) => {
                        SidebarData.map(item, index) => {
                        return (
                            <li key={index} className={item.cName}>
                                <Link to={item.path}>
                                    {item.icon}
                                    <span>{item.title}</span>
                                </Link>
                            </li>
                        );
                    }};
                </ul>
                </nav>
        </div>
      </aside>
    )
  }
}

export default withTranslation('client')(connect(mapStateToProps, mapDispatchToProps)(Home))
