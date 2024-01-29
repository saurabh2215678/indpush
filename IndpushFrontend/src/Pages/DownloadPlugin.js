import React, { useEffect, useState } from 'react'
import { useSelector } from 'react-redux';
import { apiURI } from '../utils/common';
import { useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';

function DownloadPlugin() {
    const user = useSelector((state) => state.user.user);
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false)
    const [buttonClick, setbuttonClick] = useState(false)

       async function hitApi(){
       const URL = apiURI+ '/firebase-data';
       const userID = user?.id;
       const responce = await fetch(URL, {
        method:'post',
        body:new URLSearchParams({userId:userID}),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            }
       });
       const data = await responce.json();
       console.log('jjj', data)
       if(!data.data){
        toast.success(data.message)
        navigate('/setting')
       }
    //    else{
          
    //    }
    }
    function downloadHandler(){
        const userID = user.id;
        setLoading(true);
        // const downloadFile = await fetch(apiURI + `/download-zip?userId=${userID}`)
        setbuttonClick(true);
        console.log(buttonClick)
      setTimeout(() => {
        window.location = apiURI + `/download-zip?userId=${userID}`;
        setLoading(false);
      }, 1000);
      }
    useEffect(()=>{
        hitApi()
    },[user])

  return (
    <>
    <div className='middle_login'>
    <div className="custom-block m-auto custom-block-lg custom-block-bottom ">
    <h6 class="mb-4">Still can’t find what you looking for?</h6>
    <div className='d-flex flex-wrap'>
                                <div className="custom-block-bottom-item">
                                    <a href="#" className="d-flex flex-column">
                                        <i className="custom-block-icon bi-play"></i>

                                        <small>How To Use</small>
                                    </a>
                                </div>

                                <div className="custom-block-bottom-item">
                                    <a href="#" className="d-flex flex-column">
                                        <i className="custom-block-icon bi-filetype-pdf"></i>

                                        <small>User Guide PDF</small>
                                    </a>
                                </div>

                                <div className="custom-block-bottom-item">
                                    <a href="#" className="d-flex flex-column">
                                        <i className="custom-block-icon bi-browser-chrome"></i>

                                        <small>WEbsite</small>
                                    </a>
                                </div>

                                <div className="custom-block-bottom-item">
                                    <a href="#" className={loading ? "wait" : 
                buttonClick ? "done":'d-flex flex-column'} onClick={downloadHandler}>
                                        <i className="custom-block-icon bi-arrow-down"></i>
                                        <small >{loading ? 'loading' : 'Download Plugin'}</small>
                                    </a>
                                </div>
                                </div>
                                    {buttonClick &&
                                    <>
                                    {
                                    loading ? <div></div> : <div>Download Success</div>
                                    }
                                    </>
                                     }
                                    </div>
    </div>
      
    </>
  )
}

export default DownloadPlugin