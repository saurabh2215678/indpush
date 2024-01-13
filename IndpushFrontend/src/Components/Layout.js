import React from 'react'
import Leftpanel from './Leftpanel'
import Nav from './Nav'
import { Outlet } from 'react-router-dom'

function Layout() {
  return (
    <div>
        
        <Nav/>
        <Leftpanel/>
        <Outlet/>
    </div>
  )
}

export default Layout;