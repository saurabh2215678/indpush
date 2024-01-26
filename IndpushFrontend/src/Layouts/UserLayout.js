import React, { useEffect } from 'react'
import Leftpanel from '../Components/Leftpanel'
import Nav from '../Components/Nav'
import { Outlet, useNavigate } from 'react-router-dom'
import { useSelector } from 'react-redux';

function UserLayout() {
  const navigate = useNavigate();
  const user = useSelector((state) => state.user.user);
  let headerHeight = 0;

  function setHeaderHeight() {
    const headerElement = document.querySelector('header');
    if (headerElement && headerHeight !== headerElement.offsetHeight) {
      headerHeight = headerElement.offsetHeight;
      document.documentElement.style.setProperty('--header-height', `${headerHeight}px`);
    }
    requestAnimationFrame(setHeaderHeight);
  }
  requestAnimationFrame(setHeaderHeight);
  
  useEffect(() => {
    if (!user) {
      navigate('/login');
    }else if(user.varified !== '1'){
      navigate('/verify-account');
    }
  }, [user, navigate]);

  return (
    <div>
        <Nav/>
        {user?.varified === '1' && <Leftpanel/>}
        <Outlet/>
    </div>
  )
}

export default UserLayout;