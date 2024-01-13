import React from 'react'
import Header from '../Components/Header'
import { Outlet } from 'react-router-dom'

function WebsiteLayout() {
  return (
    <div>
        <Header />
        <Outlet />
    </div>
  )
}

export default WebsiteLayout