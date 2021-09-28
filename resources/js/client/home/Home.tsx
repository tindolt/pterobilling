import { RootState } from '@/client/redux'
import { GlobalState, setCurrentRouteName } from '@/client/redux/modules/global'
import React from 'react'
import { I18nextProviderProps, withTranslation } from 'react-i18next'
import { connect } from 'react-redux'
import { CombinedState } from 'redux'

const mapStateToProps = (state: RootState): CombinedState<GlobalState> => state.global
const mapDispatchToProps = { setCurrentRouteName }

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
      <!-- SideBar Container -->
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
            <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="http://demo.pterobilling.org/my" class="nav-link  active ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="http://demo.pterobilling.org/my/server" class="nav-link ">
                        <i class="fas fa-server nav-icon"></i>
                        <p>My Servers</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://panel.example.com" class="nav-link" target="_blank">
                        <i class="fas fa-columns nav-icon"></i>
                        <p>Pterodactyl Panel</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://pma.example.com" class="nav-link" target="_blank">
                        <i class="fas fa-tools nav-icon"></i>
                        <p>phpMyAdmin</p>
                    </a>
                </li>
                <li class="nav-header">ACTIVE SERVERS</li>
                                <li class="nav-header">BILLING</li>
                <li class="nav-item">
                    <a href="http://demo.pterobilling.org/my/invoice" class="nav-link ">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>Invoices</p>
                    </a>
                </li>
                <li class="nav-header">SUPPORT CENTER</li>
                <li class="nav-item">
                    <a href="http://demo.pterobilling.org/my/ticket" class="nav-link ">
                        <i class="fas fa-ticket-alt nav-icon"></i>
                        <p>Support Tickets</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="http://demo.pterobilling.org/kb" class="nav-link">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Knowledge Base</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="http://demo.pterobilling.org/status" class="nav-link">
                        <i class="fas fa-network-wired nav-icon"></i>
                        <p>System Status</p>
                    </a>
                </li>
                <li class="nav-header">ACCOUNT</li>
                <li class="nav-item">
                    <a href="http://demo.pterobilling.org/my/affiliate" class="nav-link ">
                        <i class="fas fa-user-friends nav-icon"></i>
                        <p>Affiliate Program</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="http://demo.pterobilling.org/my/credit" class="nav-link ">
                        <i class="fas fa-money-bill-wave nav-icon"></i>
                        <p>Account Credit</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="http://demo.pterobilling.org/my/account" class="nav-link ">
                        <i class="fas fa-cog nav-icon"></i>
                        <p>Account Settings</p>
                    </a>
                </li>
            </ul>
        </nav>
        </div>
      </aside>
    )
  }
}

export default withTranslation('client')(connect(mapStateToProps, mapDispatchToProps)(Home))
