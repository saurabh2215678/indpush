import React from 'react'
import Header from '../Components/Header'
import { Outlet } from 'react-router-dom'

function WebsiteLayout() {
  return (
    <>
        {/* <Header /> */}
        <Outlet />

    </>
  )
}

export default WebsiteLayout