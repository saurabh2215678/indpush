import React, { useEffect, useRef, useState } from 'react'
import { apiURI } from '../utils/common'
import { useSelector, useDispatch } from "react-redux";

function ProfileUpadate() {
    const [formData, setFormData] = useState({});
    const user = useSelector((state) => state.user.user);
    const photoref = useRef();

    function handleChange(e){
        e.preventDefault();
        const name = e.target.name;
        const value = e.target.value;
        setFormData(
            {...formData, [name]: value}
            );
       
    }


   async function hitApi(e){
    e.preventDefault();
    // console.log(photoref.current.files[0])
        const file =  photoref.current.files[0];
        const URL = apiURI+ '/update-profile';
        const _formData = new FormData();
        _formData.append('name', formData.name);
        _formData.append('email', formData.email);
        _formData.append('password', formData.password); 
        _formData.append('domains', formData.domains);
        _formData.append('your_domain', formData.your_domain);
        _formData.append('profile_picture', file);


        const responce = await fetch(URL, {
            method:'post',
            body: _formData,
            // headers: {
            //     "Content-Type": "application/x-www-form-urlencoded",
            //     }
        });
        const data = await responce.json()
        if(responce.status == 200){
            window.location.reload()
        }
        console.log(data)
    }

    useEffect(() => {
      console.log(formData)
    }, [formData]);

    useEffect(()=>{
      setFormData(user)
    },[user]);
    
  return (
    <div>
        <div className='middle_login'>
            <div className='middle_login_inner'>
                <div className='custom-block bg-white'>
                <h3 className="mb-3"><a href="/">LOGO</a></h3>
                <form className="custom-form profile-form" onSubmit={hitApi}>
                    <input className="form-control" value={formData.name} type="text" onChange={handleChange} name="name" placeholder="Name" />
                    <input className="form-control"  value={formData.email} onChange={handleChange}  type="text" name="email"  placeholder="Email Id" />
                    <input className="form-control" value={formData.domains} onChange={handleChange} type="text" name="domains" placeholder="Domain Name" />
                    <input className="form-control" value={formData.user_domain} name="your-domain" onChange={handleChange} type="text" name="your_domain" placeholder="Your Domain"/>
                    <input type='file' className="form-control" name='profile_picture' ref={photoref} />
                    <button type="submit" className="form-control ms-2" >Submit</button> 
                </form>
                </div>
            </div>
        </div>
    </div>
  )
}

export default ProfileUpadate